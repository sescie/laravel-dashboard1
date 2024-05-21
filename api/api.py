from fastapi import FastAPI
from fastapi.responses import JSONResponse
from fastapi.requests import Request
from fastapi.encoders import jsonable_encoder
from pydantic import BaseModel
from sklearn.preprocessing import MinMaxScaler
import numpy as np
from sqlalchemy import Column, Integer, Float
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy import create_engine
from sqlalchemy.orm import Session

import pickle

app = FastAPI()

class InputData(BaseModel):
    input_data: list

Base = declarative_base()

class EnergyUsed(Base):
    __tablename__ = 'energy_Useds'
    id = Column(Integer, primary_key=True)
    KW = Column(Float)

class EnergyPred(Base):
    __tablename__ = 'energy_Preds'
    id = Column(Integer, primary_key=True)
    KW = Column(Float)
    def to_dict(self):
        return dict(self.__dict__)

engine = create_engine('mysql+pymysql://root:0000@localhost:3306/boiler_plate')
Base.metadata.bind = engine

@app.post("/predict")
async def predict(request: Request):
    try:
        session = Session(engine)
        input_data = session.query((EnergyUsed.KW)).order_by(EnergyUsed.id.asc()).limit(24).all()
        input_data = np.array(input_data).reshape(-1, 1)
        with open('models/rnn_model.pkl', 'rb') as file:
            regressor = pickle.load(file)
        sc = MinMaxScaler(feature_range=(0, 1))
        input_data_scaled = sc.fit_transform(input_data)
        predicted_load = regressor.predict(input_data_scaled)
        predicted_load = sc.inverse_transform(predicted_load)
        predicted_values = []
        for i in range(24):
            predicted_value = EnergyPred(KW=predicted_load[i][0])
            session.add(predicted_value)
            predicted_values.append(predicted_value)
        session.commit()
        return JSONResponse(content={'message': 'Predictions made and stored successfully!'}, media_type='application/json')
    except Exception as e:
        return JSONResponse(content={'error': str(e)}, media_type='application/json', status_code=500)
    