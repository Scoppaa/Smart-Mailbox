#!/usr/bin/env python3.5
from gpiozero import MotionSensor
import time
import os
#Motion sensor in GPIO23
ms = MotionSensor(23)

def send_notification():
    #Debug Motion Statement
    print("There was a movement!")
    print("Notification sent!")
    #Notification script is stored in notification variable
    notification = os.popen ('bash /home/pi/project/notification.sh')
    #Send Notification
    print(notification.read())
    #Delay between notifications
    time.sleep(15)

#Execute send_notification function on motion
ms.when_motion = send_notification
