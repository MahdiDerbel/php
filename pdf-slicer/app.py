from fastapi import Form, File, UploadFile, Request, FastAPI
from typing import List
from fastapi.responses import HTMLResponse

from werkzeug.utils import secure_filename
import json
import os
from ExtractTable import ExtractTable
import uvicorn
import PyPDF2
import re
import sys
from PyPDF2 import PdfFileWriter,PdfFileReader
import base64
import pandas as pd

app = FastAPI()

def extract_page_num(keyTerm,filename):
    
    
    object = PyPDF2.PdfFileReader(filename)

    
    NumPages = object.getNumPages()
    
    
    for i in range(4, NumPages):
        PageObj = object.getPage(i)
        Text = PageObj.extractText()
        Text = Text.replace('˜','fi')
        reSearch = re.findall(keyTerm, Text)
        if reSearch:
            return i

def fix_schema(file):
    L=[]
    L1=[]
    search_list=['3.2','3.2. S','3.2. S.1','3.2. S.1.1','3.2. S.1.2','3.2. S.1.3','3.2. S.2','3.2. S.2.1','3.2. S.2.2','3.2. S.2.3','3.2. S.2.4','3.2. S.2.5','3.2. S.2.6','3.2. S.3','3.2. S.3.1','3.2. S.3.2','3.2. S.4','3.2. S.4.1','3.2. S.4.2','3.2. S.4.3','3.2. S.4.4','3.2. S.4.5','3.2. S.5','3.2. S.6','3.2. S.7','3.2. S.7.1','3.2. S.7.2','3.2. S.7.3','3.2. P.1','3.2. P.2','3.2. P.2.1','3.2. P.2.1.1','3.2. P.2.1.2','3.2. P.2.2.1','3.2. P.2.2.2','3.2. P.2.2.3','3.2. P.2.3','3.2. P.2.4','3.2. P.2.5','3.2. P.2.6','3.2. P.3','3.2. P.3.1','3.2. P.3.2','3.2. P.3.3','3.2. P.3.4','3.2. P.3.5','3.2. P.4','3.2. P.4.1','3.2. P.4.2','3.2. P.4.3','3.2. P.4.4','3.2. P.4.5','3.2. P.4.6','3.2. P.5','3.2. P.5.1','3.2. P.5.2','3.2. P.5.3','3.2. P.5.4','3.2. P.5.5','3.2. P.5.6','3.2. P.6','3.2. P.7','3.2. P.8','3.2. P.8.1','3.2. P.8.2','3.2. P.8.3']
    for i in search_list:
        bs_no=extract_page_num(i,file)
        L.append(bs_no)
        L1.append(i)
    df = pd.DataFrame()
    df.insert(0, "chapter name",L1,allow_duplicates=False)
    df.insert(0, "Page",L,allow_duplicates=True)
    return(df)

def pdf_encode(pdf_filename):
    with open(pdf_filename, "rb") as pdf_file:
        encoded_string = base64.b64encode(pdf_file.read())
    return (encoded_string)

def pdf_splitter(file,pdfdata):
    dict1={}
    dict={}
    
    L=[]
    for k in range(len(pdfdata)):
        string=''
        path=""
        path2=""
        if k+1<len(pdfdata):
            j=k+1
            print(pdfdata['Page'][j])
            start=int(pdfdata['Page'][k])
            end=int(pdfdata['Page'][j]+1)
            new_file_name = pdfdata['chapter name'][k] + ".pdf"
            print("dfk",pdfdata['chapter name'][k])
            print(new_file_name)
            read_file = PyPDF2.PdfFileReader(file) #read pdf
            
            
            new_pdf = PyPDF2.PdfFileWriter() #create write object
            #start-=1
            path=os.path.join(path, "files", new_file_name)
            path2=os.path.join(path2, "media\\files", new_file_name)
            try:
                
                with open(path,"wb") as f:
                    
                    for i in range(start, end):
                        page = read_file.getPage(i)
                        page.compressContentStreams()
                        new_pdf.addPage(page)
                        
                        new_pdf.write(f)
                        i+=1
                    #string=pdf_encode(path)
                    dict1[pdfdata['chapter name'][k]]=path2
                    L.append(dict1)
                    dict1={}
                    
            except Exception as e:
                print(e)
                print('IMHERE')
    
        else :
            start=pdfdata['Page'][len(pdfdata)-1]
            end=len(pdfdata)
       
    
    return(L)
@app.get("/", response_class=HTMLResponse)
def main(request: Request):
    return templates.TemplateResponse("index.html", {"request": request})

@app.post("/submit")
def submit(id_module: str = Form(...),id_chapitre: str = Form(...),id_produit: str = Form(...),fichier: UploadFile = File(...)):
    file_location = f"files/{fichier.filename}"
    with open(file_location, "wb+") as file_object:
        file_object.write(fichier.file.read())
    df=fix_schema(file_location)
    resp=pdf_splitter(file_location,df)
    resp1=tuple(resp)
    with open('readme.txt', 'w') as f:
        f.write(str(resp1))

    return resp1
if __name__=="__main__":
    uvicorn.run("app:app",host='0.0.0.0', port=4557, reload=True, debug=True, workers=3)