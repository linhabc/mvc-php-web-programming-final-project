import {getHttpObject} from '../index.js'

function checkResult() {
    httpObject = getHTTPObject(); 
    if (httpObject != null) { 
        httpObject.open("POST", "?user/QuickTest/checkResult", true); 
        httpObject.send(null); 
        httpObject.onreadystatechange=setOutput; 
    }
}