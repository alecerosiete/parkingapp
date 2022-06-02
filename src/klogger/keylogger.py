
#!/usr/bin/env python
from pynput.keyboard import Key, Listener
from subprocess import getoutput
from datetime import datetime

import logging
import time

log_dir = "/wamp64/www/parking.sekur.com.py/src/klogger/"
logging.basicConfig(filename=(log_dir+"keylogger.log"), \
	level =logging.DEBUG,format ='%(message)s')

APP_FOLDER = "C:/wamp64/www/parking.sekur.com.py"

APP_ROOT = "C:/wamp64/www/parking.sekur.com.py/index.php"

frase=""
b = 0
t = 0
btnSleep = 2
TICKET_CODIGO = "00"
TICKET_LEN = 16
RFID_CODIGO = "00"
RFID_LEN  = 10

def on_read(ticketId):
  
    codigo = ticketId[0:2];
    if(len(ticketId) == TICKET_LEN and TICKET_CODIGO == codigo):
        result = getoutput('php '+APP_ROOT+' BarcodeReader/read/'+ticketId)
        result += "Es un codigo valido"
    else:
        result = "No corresponde a un ticket"
    logging.info("ON READ TICKET<"+ticketId+">: "+result)

def on_press_button():
    result = getoutput('php '+APP_ROOT+'  BarcodeReader/onButtonPress/')
    #result_print = getoutput("curl http://localhost/printer/testPrint.php?p="+result)
    logging.info("on button press result: "+result)
    #logging.info("print service result: "+result_print)

def on_press(key):
    global frase
    global b
    global t
    global btnSleep
    
    if(str(key) == "Key.f9"):
        if(b == 0):
            b = int(datetime.timestamp(datetime.now()))
            logging.info("ACTIVANDO BARRERA DE ENTRADA ")
            on_press_button()
        else:
            t = int(datetime.timestamp(datetime.now()))
            if((t-b) > btnSleep):
                logging.info("Transcurrieron "+str(t-b)+" segundos.. desbloqueando el boton")
                logging.info("ACTIVANDO BARRERA DE ENTRADA")
                on_press_button()
                b = int(datetime.timestamp(datetime.now()))
            else:
                logging.info("Contando.. "+str(t-b)+" segundos.."+str(key))
        frase = ""
    logging.info("ACTUAL KEY: "+str(key))
    logging.info("ACTUAL FRASE: "+frase)

    #si se lee un enter, verificar si se leyo en caja o se leyo una tarjeta
    if(str(key) == "Key.enter"):
        text = frase.replace("'","")        
        rfid = text[-10:]
        codigo = text[0:2]
        if len(rfid) == RFID_LEN and RFID_CODIGO == codigo:
            logging.info("Key enter: se leyo numero de 10 digitos, procesando tarjeta rfid")
            result = getoutput('php '+APP_ROOT+' Rfid_reader/goToOut/'+text)
            result += "Leyendo tarjeta rifd"
            #return true
            logging.info(result)
            frase=""
        else:
            logging.info("Key enter: se leyo en la caja, limpiando frase")
            frase=""
    else:
        if(str(key) == "Key.tab"):
            text = frase.replace("'","")   
            on_read(text.strip())
            frase=""
        else:       
            if(str(key) == "Key.f9"):
                logging.info("Key detectado F9")
            else:
                logging.info("Concatenando Frase")
                frase=frase+str(key)

with Listener(on_press=on_press) as listener:
	listener.join()
