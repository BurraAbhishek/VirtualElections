function loadCSS(n) {
    var colorModeTitle = "virtualelection_colormode";
    var s = document.createElement("link");
    s.rel = "stylesheet";
    s.setAttribute("type", "text/css");
    if(typeof(Storage) !== "undefined") {
        if(localStorage.getItem(colorModeTitle) == "Default") {
            s.href = getFileURL("css/virtualelection.css", n);
        } else if(localStorage.getItem(colorModeTitle) == "Dark") {
            s.href = getFileURL("css/virtualelection_darkmode.css", n);
        } else {
            s.href = loadCSSByTime()["href"];
            localStorage.setItem(colorModeTitle, loadCSSByTime(n)["mode"]);
        }
    } else {
        s.href = loadCSSByTime(n)["href"];
    }
    document.head.appendChild(s);
}

function loadCSSByTime(n) {
    var a;
    var d = new Date();
    if(d.getHours() >= 6 && d.getHours() < 18){
        a = {
            "mode": "Default",
            "href": getFileURL("css/virtualelection.css", n)
        }
    } else {
        a = {
            "mode": "Dark",
            "href": getFileURL("css/virtualelection_darkmode.css", n)
        }
    }
    return a;
}

function getFileURL(url, parents) {
    var path = "";
    for(var i = 0; i < parents; i++) {
        path += "../";
    }
    path += url;
    return path;
}