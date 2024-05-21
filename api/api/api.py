from fastapi import FastAPI, HTTPException # type: ignore
from pydantic import BaseModel
from sqlalchemy import Column, Integer, Float, DateTime, ForeignKey, Boolean
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import relationship, sessionmaker
from sqlalchemy.sql import func
import serial

Base = declarative_base()

class Appliance(Base):
    __tablename__ = "appliances"
    id = Column(Integer, primary_key=True)
    name = Column(str)
    running = Column(Boolean, default=False)
    top_priority = Column(Boolean, default=False)
    port = Column(Integer)
    created_at = Column(DateTime, default=func.now())
    updated_at = Column(DateTime, default=func.now(), onupdate=func.now())

class EnergyUsed(Base):
    __tablename__ = "energy_used"
    id = Column(Integer, primary_key=True)
    appliance_id = Column(Integer, ForeignKey("(link unavailable)"))
    appliance = relationship("Appliance", backref="energy_used")
    kw = Column(Float)
    created_at = Column(DateTime, default=func.now())
    updated_at = Column(DateTime, default=func.now(), onupdate=func.now())

class ApplianceCreate(BaseModel):
    name: str
    running: bool
    top_priority: bool
    port: int

class StartDataCollection(BaseModel):
    appliance_id: int

app = FastAPI()

# Database connection
engine = create_engine("sqlite:///energy.db")
Base.metadata.create_all(engine)
Session = sessionmaker(bind=engine)
db_session = Session()

@app.post("/api/appliances")
async def create_appliance(appliance: ApplianceCreate):
    db_appliance = Appliance(name=appliance.name, running=appliance.running, top_priority=appliance.top_priority, port=appliance.port)
    db_session.add(db_appliance)
    db_session.commit()
    return {"message": "Appliance created successfully"}

@app.post("/api/start-data-collection")
async def start_data_collection(data: StartDataCollection):
    appliances = db_session.query(Appliance).filter(Appliance.running == True).order_by(Appliance.id.asc()).all()
    for appliance in appliances:
        if (link unavailable) == data.appliance_id:
            energy_used = EnergyUsed(appliance_id=(link unavailable), kw=0)
            db_session.add(energy_used)
    db_session.commit()
    return {"message": "Data collection started"}

@app.put("/api/appliances/{appliance_id}/toggle")
async def toggle_appliance(appliance_id: int):
    appliance = db_session.query(Appliance).get(appliance_id)
    if appliance:
        appliance.running = not appliance.running
        db_session.commit()
        return {"message": f"Appliance {appliance_id} toggled"}
    else:
        return {"error": f"Appliance {appliance_id} not found"}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000)