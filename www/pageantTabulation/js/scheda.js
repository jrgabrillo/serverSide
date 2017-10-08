/**
 * scheda.js
 * http://ravenjohn.github.io/scheda.js
 */

(function (root) {
    "use strict";

    /* jslint browser: true, regexp: true */

    var scheda = {},
        history = [],
        save = true,
        canvas_id,
        canvas,
        c,
        w,
        h,
        conf = {
            bgColor : "#fff",
            headerBgColor : "#ccc",
            miniGridColor : "#000",
            hMainGridColor : "#000",
            vMainGridColor : "#000",
            timeColumnWidth : 50,
            time : {
                color : "#000",
                bgColor : "#ccc",
                style : "normal",
                font : "Arial",
                size : 13
            },
            day : {
                color : "#000",
                style : "normal",
                font : "Arial",
                size : 13
            },
            sched : {
                color : "#000",
                style : "normal",
                font : "Arial",
                size : 12
            }
        },

        cvrt = function (e, f) {
            e.length < 3 && (e += "00");
            e = parseInt(e, 10);
            (e < 700 || (f && e === 700)) && (e += 1200);
            e += "";
            return ((parseInt(e.substring(0, e.length - 2), 10) - 7) * 4) + (parseInt(e.substring(e.length - 2), 10) / 15);
        },

        tC = function (w, c, t) {
            return (w - c.measureText(t).width) / 2;
        },

        gTop = function (x, ma, h, w, c) {
            var my = Math.floor(ma / 4) * h + h;
            switch (ma % 4) {
            case 0:
                c.lineTo(x, my);
                c.lineTo(x + w, my);
                break;
            case 1:
                c.lineTo(x, my);
                c.lineTo(x + (w / 2), my + (h / 2));
                c.lineTo(x + w, my);
                break;
            case 2:
                c.lineTo(x, my);
                c.lineTo(x + w, my + h);
                break;
            case 3:
                c.lineTo(x, my + h);
                c.lineTo(x + (w / 2), my + (h / 2));
                c.lineTo(x + w, my + h);
                break;
            }
        },

        gBottom = function (x, ma, h, w, c) {
            var my = Math.floor(ma / 4) * h + h;
            switch (ma % 4) {
            case 0:
                c.lineTo(x + w, my);
                c.lineTo(x, my);
                break;
            case 1:
                c.lineTo(x + w, my);
                c.lineTo(x + (w / 2), my + (h / 2));
                c.lineTo(x, my);
                break;
            case 2:
                c.lineTo(x + w, my + h);
                c.lineTo(x, my);
                break;
            case 3:
                c.lineTo(x + w, my + h);
                c.lineTo(x + (w / 2), my + (h / 2));
                c.lineTo(x, my + h);
                break;
            }
        },

        uuid = function (separator) {
            var S4 = function () {
                return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
            };
            return [S4() + S4(), S4(), S4(), S4(), S4() + S4() + S4()].join(separator || "-");
        };

    scheda.drawCourse = function (day, time, courseCode, sectionName, room, color, faculty) {
        var y,
            sp,
            id,
            randomColor = function () {
                var rn = function () {
                    return parseInt(Math.random() * 255, 10);
                };
                return "rgb(" + rn() + ", " + rn() + ", " + rn() + ")";
            },
            draw = function (xx) {
                var x = (xx * w) + conf.timeColumnWidth;
                c.beginPath();
                gTop(x, time[0], h, w, c);
                gBottom(x, time[1] + time[0], h, w, c);
                c.strokeStyle = c.fillStyle = color;
                c.fill();
                c.lineWidth = 0.5;
                c.fillStyle = conf.sched.color;
                c.font = conf.sched.style + " " + conf.sched.size + "px " + conf.sched.font;

                if (room === "") {
                    c.fillText(courseCode, tC(w, c, courseCode) + x, y + (sp / 2) - 0);
                } else {
                    c.fillText(courseCode, tC(w, c, courseCode) + x, y + (sp / 2) - 0);
                    c.fillText(room, tC(w, c, room) + x+40, y + (sp / 2) + 15);
                }
                // if(sectionName != ""){
                //     c.fillText(sectionName, tC(w, c, sectionName) + x+40, y + (sp / 2) + 0);                    
                // }
                if(faculty != ""){
                    c.fillText(faculty, tC(w, c, faculty) + x-40, y + (sp / 2) + 15);                    
                }
                c.stroke();
            };

        save && history.push({id : (id = uuid()), args : arguments});
        time = time.replace(/:/g, "").split("-");
        time[1] = cvrt(time[1], 1) - (time[0] = cvrt(time[0]));
        y = (time[0] / 4) * h + h;
        sp = (time[1] / 4) * h;
        room = room || "TBA"; // room = room || "";
        faculty = faculty || "TBA"; // faculty = faculty || ""; --just added
        sectionName = sectionName || ""; //cut in course
        courseCode = courseCode + " - " + (sectionName || "");
        // courseCode = courseCode || "";
        day = day.toUpperCase();
        !color && (color = randomColor());
        if (~day.indexOf("M")) {
            draw(0);
        }
        if (~day.indexOf("TH")) {
            draw(3);
            day = day.replace("TH", "");
        }
        if (~day.indexOf("T")) {
            draw(1);
        }
        if (~day.indexOf("W")) {
            draw(2);
        }
        if (~day.indexOf("F")) {
            draw(4);
        }
        if (~day.indexOf("S")) {
            draw(5);
        }

        return id;
    };

    scheda.setConfig = function (config) {
        var i,
            j;
        for (i in config) {
            if (config.hasOwnProperty(i) && conf[i]) {
                if (typeof config[i] === "object") {
                    for (j in config[i]) {
                        conf[i][j] = config[i][j];
                    }
                } else {
                    conf[i] = config[i];
                }
            }
        }
        scheda.repaint();
    };

    scheda.getConfig = function (p) {
        switch ((p = p.split(".")).length) {
        case 1: return conf[p[0]];
        case 2: return conf[p[0]][p[1]];
        }
    };

    scheda.repaint = function () {
        var i;
        scheda.init();
        save = false;
        for (i in history) {
            i > -1 && scheda.drawCourse.apply(undefined, history[i].args);
        }
        save = true;
    };

    scheda.remove = function (id) {
        var i;
        for (i in history) {
            i > -1 && id === history[i].id && history.splice(i, 1);
        }
        scheda.repaint();
    };

    scheda.getHistory = function () {
        return history;
    };

    scheda.getCourse = function (id) {
        var i;
        for (i in history) {
            if (i > -1 && id === history[i].id) {
                return history[i].arguments;
            }
        }
    };

    scheda.updateCourse = function (id, args) {
        var i;
        for (i in history) {
            i > -1 && id === history[i].id && (history[i].arguments = args);
        }
        scheda.repaint()
    };

    scheda.init = function (id, config) {
        var days = ["Mon", "Tues", "Wednes", "Thurs", "Fri", "Satur"],
            i,
            j;

        id = id || canvas_id;

        if (!(canvas = document.getElementById(id))) {
            throw new Error("Unable to find canvas with id [" + id + "]");
        }

        canvas.width === 300 && (canvas.width = 811);
        canvas.height === 150 && (canvas.height = 600);
        c = canvas.getContext("2d");
        h = canvas.height / 16;
        w = (canvas.width - conf.timeColumnWidth) / 6;
        config && scheda.setConfig(config);
        canvas_id = id;

        // draw canvas background
        c.fillStyle = conf.bgColor;
        c.fillRect(0, 0, canvas.width, h * 16);

        // draw table header bg
        c.fillStyle = conf.headerBgColor;
        c.fillRect(0, 0, canvas.width, h);

        // draw mini grid
        c.beginPath();
        c.strokeStyle = conf.miniGridColor;
        for (i = 0, j = (h / 2) + h; i < 48; i += 1, j += (h / 2)) {
            c.moveTo(0, j);
            c.lineTo(canvas.width, j);
        }
        c.stroke();

        // draw time bg
        c.fillStyle = conf.time.bgColor;
        c.fillRect(0, h, conf.timeColumnWidth, canvas.height);

        // draw horizontal main grid
        c.beginPath();
        c.strokeStyle = conf.hMainGridColor;
        for (i = 0, j = h; i < 16; i += 1, j += h) {
            c.moveTo(0, j);
            c.lineTo(canvas.width, j);
        }
        c.stroke();

        // draw vertical main grid
        c.beginPath();
        c.strokeStyle = conf.vMainGridColor;
        c.moveTo(conf.timeColumnWidth, 0);
        c.lineTo(conf.timeColumnWidth, canvas.height);
        for (i = 0; i < 7; i += 1) {
            c.moveTo(i * w + conf.timeColumnWidth, 0);
            c.lineTo(i * w + conf.timeColumnWidth, canvas.height);
        }
        c.stroke();

        // draw time labels
        c.beginPath();
        c.fillStyle = conf.time.color;
        c.font = conf.time.style + " " + conf.time.size + "px " + conf.time.font;

        var start = 7, end = 22, count=12;
        for (i = start; i < end; i += 1) {
            if (i === count) {
                j = i + "-1";
            } else if (i > count) {
                j = (i - count) + "-" + (i - 11);
            } else {
                j = i + "-" + (i + 1);
            }
            c.fillText(j, tC(conf.timeColumnWidth, c, j), ((h / 2) + (conf.time.size / 2)) + ((i - 7) * h) + h);
        }

        // draw day labels
        c.fillStyle = conf.day.color;
        c.font = conf.day.style + " " + conf.day.size + "px " + conf.day.font;
        c.fillText("Time", tC(conf.timeColumnWidth, c, "Time"), ((h / 2) + (conf.day.size / 2)));
        for (i in days) {
            i > -1 && c.fillText(days[i] + "day", conf.timeColumnWidth + tC(w, c, days[i] + "day") + (i * w), ((h / 2) + (conf.day.size / 2)));
        }
    };

    scheda.downloadSchedule = function (e) {
        var a = document.createElement("a");
        a.setAttribute('download', 'schedule');
        a.type = "image/png";
        a.target = '_blank';
        a.href = canvas.toDataURL();
        a.onclick = function () {
            this.parentNode.removeChild(this);
        };
        document.getElementsByTagName("body")[0].appendChild(a);
        a.click();
        e && e.preventDefault();
    };

    // expose scheda fn
    root.scheda = scheda;
}(this));
