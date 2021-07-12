import { filter } from 'lodash';
import moment from 'moment';
import Chart from "chart.js/auto";
import { data } from 'jquery';


const { invalid } = require("moment");

let mainActivities = timerData["mainActivities"];
let subActivities = timerData["subActivities"];
let fixedOptions = timerData["fixedOptions"];
let scaledOptions = timerData["scaledOptions"];
let logs = logss;

subActivities.push("total")

const logCount = "log count";
const totalTime = "total time";
const timePerLog = "time per log";
const averageTimePerDay = "daily ave time";
const averageLogCountPerDay = "daily ave logcount";
const averageTimePerWeek = "weekly ave time";
const averageLogCountPerWeek = "weekly ave logcount";

const activitiesOutputOptions = {
    day: [logCount, totalTime, timePerLog],
    week: [
        logCount,
        totalTime,
        timePerLog,
        averageTimePerDay,
        averageLogCountPerDay
    ],
    month: [
        logCount,
        totalTime,
        timePerLog,
        averageTimePerDay,
        averageLogCountPerDay,
        averageTimePerWeek,
        averageLogCountPerWeek
    ]
};

let timeInterval = "day";
let headers;


// // console.log("logs are ", logs)


const clearRows = () => {

    document.getElementById("activityRows").textContent = "";
    document.getElementById("fixedRows").textContent = "";
    document.getElementById("scaledRows").textContent = "";

}

const getTimeInterval = () => {


    document.getElementById("day").addEventListener("click", event => {
        // // console.log("day", event.target.value)
        timeInterval = "day";
        clearRows()
    });
    document.getElementById("week").addEventListener("click", event => {
        // // console.log("week", event.target.value)
        timeInterval = "week";
        clearRows()

    });
    document.getElementById("month").addEventListener("click", event => {
        // // console.log("month", event.target.value)
        timeInterval = "month";
        clearRows()

    });
};

getTimeInterval();

// console.log("logs are ", logs);
// console.log("timerdata are ", mainActivities);

const createSelection = (selectionId, selectOptions) => {
    let select = document.createElement("select");
    select.id = selectionId;
    selectOptions.forEach(selectOption => {
        let newOption = document.createElement("option");
        newOption.value = selectOption;
        newOption.text = selectOption;
        select.appendChild(newOption);
    });

    return select;
};

const createActivitiesRow = () => {
    let mainDiv = document.createElement("div");
    mainDiv.classList.add("rowDiv")

    let mainActSelect = createSelection("mainActivities", mainActivities);
    let subActSelect = createSelection("subActivities", subActivities);
    let output;
    if (timeInterval == "day") {
        output = createSelection("output", activitiesOutputOptions["day"]);

    }
    if (timeInterval == "week") {
        output = createSelection("output", activitiesOutputOptions["week"]);

    }
    if (timeInterval == "month") {
        output = createSelection("output", activitiesOutputOptions["month"]);

    }
    const label = document.createElement("label")
    label.innerHTML = "-"

    mainDiv.appendChild(label)
    mainDiv.appendChild(mainActSelect);
    mainDiv.appendChild(subActSelect);
    mainDiv.appendChild(output);

    const div = document.getElementById("activityRows");
    div.appendChild(mainDiv);
};


const createFixedRow = () => {
    let mainDiv = document.createElement("div");
    mainDiv.classList.add("rowDiv")

    let fixedSelect = createSelection("fixedOptions", Object.keys(fixedOptions));
    let mainActSelect = createSelection("mainActivities", mainActivities);
    let subActSelect = createSelection("subActivities", subActivities);
    let output;
    if (timeInterval == "day") {
        output = createSelection("output", activitiesOutputOptions["day"]);

    }
    if (timeInterval == "week") {
        output = createSelection("output", activitiesOutputOptions["week"]);

    }
    if (timeInterval == "month") {
        output = createSelection("output", activitiesOutputOptions["month"]);

    }
    const label = document.createElement("label")
    label.innerHTML = "-"
    mainDiv.appendChild(label)

    mainDiv.appendChild(fixedSelect);

    mainDiv.appendChild(mainActSelect);
    mainDiv.appendChild(subActSelect);
    mainDiv.appendChild(output);

    const div = document.getElementById("fixedRows");
    div.appendChild(mainDiv);


}


const createScaledRow = () => {
    let mainDiv = document.createElement("div");
    mainDiv.classList.add("rowDiv")
    let scaledSelect = createSelection("scaledOptions", scaledOptions);
    let mainActSelect = createSelection("mainActivities", mainActivities);
    let subActSelect = createSelection("subActivities", subActivities);
    let output = createSelection("output", ["average"]);

    const label = document.createElement("label")
    label.innerHTML = "-"
    mainDiv.appendChild(label)

    mainDiv.appendChild(scaledSelect);

    mainDiv.appendChild(mainActSelect);
    mainDiv.appendChild(subActSelect);
    mainDiv.appendChild(output);

    const div = document.getElementById("scaledRows");
    div.appendChild(mainDiv);


}




document.getElementById("activityInput").addEventListener("click", event => {
    createActivitiesRow();
    // // console.log("le fuck")
});


document.getElementById("fixedInput").addEventListener("click", event => {
    createFixedRow();
    // // console.log("le fuck")
});

document.getElementById("scaledInput").addEventListener("click", event => {
    createScaledRow();
    // // console.log("le fuck")
});


const getChildElements = (rowName) => {

    let options = []
    const kak = document.getElementById(rowName).childNodes
        // console.log("---------------- ", kak)

    kak.forEach(element => {
        const kut = element.childNodes
        let row = []
        console.log("kut meuk ", kut)
        kut.forEach(tering => {
            if (tering.tagName == "SELECT") {
                row[tering.id] = tering.value

            }
        });
        // console.log("row meuk ", row)
        if (Object.keys(row).length != 0) {
            options.push(row)

        }

        // console.log("row lenght ", Object.keys(row).length, row)



    });
    // console.log("foun optionds ", options)
    // options.shift()
    return options

}





const getRowData = () => {

    let rowOptions = {
        "scaledOptions": getChildElements("scaledRows"),
        "fixedOptions": getChildElements("fixedRows"),
        "activityOptions": getChildElements("activityRows")


    }

    return rowOptions





}





//1: bepaal startdate van eerste en laatste log, aan de hand van day,week,month timeinterval
// genereer de benodigde columnheader
const getColumnHeaders = () => {
    console.log("get headers test ", logs[0]);
    // // // console.log("timerineterval ", timeInterval)
    // moment(document.getElementById("end").value, "YYYY-MM-DD");
    const startDate = moment(dates["startDate"], "YYYY-MM-DD");
    const endDate = moment(dates["endDate"], "YYYY-MM-DD");
    // const diff = endDate.subtract(startDate)
    const columnHeaders = []
    if (timeInterval == "day") {
        const diffInDays = endDate.diff(startDate, "days");
        // console.log("diff in days ", diffInDays)
        for (let index = 0; index < diffInDays; index++) {
            // const element = diffInDays;
            const startNewDate = startDate.clone().add(index, "day")
            const endNewDate = startDate.clone().add(index + 1, "day")
            const startNewDateUnix = startNewDate.unix()
            const experiment = ""
            for (let index = 0; index < logs.length; index++) {
                const temp = logs[index];
                if (temp.log.startTimestamp > startNewDateUnix) {
                    experiment = temp.log.experiments
                    break
                }

            }


            const newAdd = { "experiment": experiment, "startDate": startNewDate, "endDate": endNewDate, "columnHeader": startNewDate.format("DD-MM-YYYY"), "startDateStr": startNewDate.format("DD-MM-YYYY") }
            columnHeaders.push(newAdd)
        }

        // // // console.log("day headers", columnHeaders)
    }
    if (timeInterval == "week") {

        const diffInWeeks = endDate.diff(startDate, "week");
        // // console.log("diff in week ", diffInWeeks)
        for (let index = 0; index < diffInWeeks; index++) {
            // const element = diffInDays;
            const startNewDate = startDate.clone().add(index, "week")
            const endNewDate = startDate.clone().add(index + 1, "week")
            const startNewDateUnix = startNewDate.unix()
            const experiment = ""
            for (let index = 0; index < logs.length; index++) {
                const temp = logs[index];
                if (temp.log.startTimestamp > startNewDateUnix) {
                    experiment = temp.log.experiments
                    break
                }

            }

            const newAdd = { "experiment": experiment, "startDate": startNewDate, "endDate": endNewDate, "columnHeader": startNewDate.isoWeek(), "startDateStr": startNewDate.format("DD-MM-YYYY") }
            columnHeaders.push(newAdd)
        }
        // // console.log("week is ", columnHeaders)


    }
    if (timeInterval == "month") {
        const diffInMonths = endDate.diff(startDate, "month");
        // // console.log("diff in month ", diffInMonths)
        for (let index = 0; index < diffInMonths; index++) {
            // const element = diffInDays;
            const startNewDate = startDate.clone().add(index, "month")
            const endNewDate = startDate.clone().add(index + 1, "month")
            const startNewDateUnix = startNewDate.unix()
            const experiment = ""
            for (let index = 0; index < logs.length; index++) {
                const temp = logs[index];
                if (temp.log.startTimestamp > startNewDateUnix) {
                    experiment = temp.log.experiments
                    break
                }

            }
            const newAdd = { "experiment": experiment, "startDate": startNewDate, "endDate": endNewDate, "columnHeader": startNewDate.format('MMMM'), "startDateStr": startNewDate.format("DD-MM-YYYY") }
            columnHeaders.push(newAdd)
        }
        // // console.log("month is ", columnHeaders)
    }
    // // console.log(dates, startDate, endDate)
    // // console.log("startdate ", startDate)
    // // console.log("enddate ", endDate)
    // let headers = []


    headers = columnHeaders;
}

const divideLogs = () => {
    let newLogs = []
    headers.forEach(header => {
        let tempLogs = []
            // // console.log(header)
        logs.forEach(log => {
            // // console.log("lets go ", log.startTimestamp, header.startDate);

            if (
                moment.unix(log["log"].startTimestamp).isSameOrAfter(header.startDate) &&
                moment.unix(log["log"].startTimestamp).isBefore(header.endDate)
            ) {
                tempLogs.push(log["log"]);
            }
        });
        newLogs.push(tempLogs)
    });

    // // console.log("thse are the filtered logs ", newLogs);

    return newLogs



}


// const logCount = "log count";
// const totalTime = "total time";
// const timePerLog = "time per log";
// const averageTimePerDay = "daily ave time";
// const averageLogCountPerDay = "daily ave logcount";
// const averageTimePerWeek = "weekly ave time";
// const averageLogCountPerWeek = "weekly ave logcount";





const allCalculations = (filteredLogs, option) => {
    // console.log("launch deze meuk")
    const logCountValue = filteredLogs.length
    let totalTimeValue = 0
    let timePerLogValue = 0
    let averageTimePerDayValue = 0
    let averageLogCountPerDayValue = 0
    let averageTimePerWeekValue = 0
    let averageLogCountPerWeekValue = 0

    filteredLogs.forEach(filteredLog => {
        const startTime = moment.unix(filteredLog.startTimestamp);
        const endTime = moment.unix(filteredLog.endTimestamp);
        const diff = Math.round(
            moment.duration(endTime.subtract(startTime)).asMinutes()
        );
        totalTimeValue += diff;


    });

    timePerLogValue = Math.round(totalTimeValue / logCountValue)

    if (timeInterval == "week") {

        averageLogCountPerDayValue = Math.round(logCountValue / 5)
        averageTimePerDayValue = Math.round(totalTimeValue / 5)
    }

    if (timeInterval == "month") {

        averageLogCountPerWeekValue = Math.round(logCountValue / 20)
        averageTimePerWeekValue = Math.round(totalTimeValue / 20)
    }

    switch (option) {
        case logCount:
            return logCountValue
            break;
        case totalTime:
            return totalTimeValue
            break;
        case timePerLog:
            return timePerLogValue
            break;
        case averageTimePerDay:
            return averageTimePerDayValue
            break;
        case averageLogCountPerDay:
            return averageLogCountPerDayValue
            break;
        case averageTimePerWeek:
            return averageTimePerWeekValue
            break;
        case averageLogCountPerWeek:
            return averageLogCountPerWeekValue
            break;

    }

}



const calculateActivitiesRowData = (inputLogs, rowOptions) => {
    // console.log("werkt dit")
    let rowColumn = []
    rowOptions.forEach(rowOption => {
        // console.log("beh")
        let cellValues = []
        inputLogs.forEach(inputLogSet => {
            // console.log("bah")
            let filterLogs = []
            if (rowOption["subActivities"] == "total") {
                filterLogs = inputLogSet.filter(
                    (testLog) =>
                    testLog["mainActivities"] == rowOption["mainActivities"]

                );
            } else {
                filterLogs = inputLogSet.filter(
                    (testLog) =>
                    testLog["mainActivities"] == rowOption["mainActivities"] &&
                    testLog["subActivities"] == rowOption["subActivities"]
                );
            }

            // console.log("filter logs ", filterLogs)
            const cellValue = allCalculations(filterLogs, rowOption["output"])
            cellValues.push(cellValue)


        });
        // console.log("result ", rowOption, cellValues)
        rowColumn.push({ "rowOption": rowOption, "cellValues": cellValues })
    });

    return rowColumn
}

const calculateFixedRowData = (inputLogs, rowOptions) => {
    let rowColumn = []
    rowOptions.forEach(rowOption => {

        const subOptions = fixedOptions[rowOption["fixedOptions"]]
        subOptions.forEach(subOption => {


            let cellValues = []
            inputLogs.forEach(inputLogSet => {
                // console.log("bah")
                let filterLogs = []
                if (rowOption["subActivities"] == "total") {
                    filterLogs = inputLogSet.filter(
                        (testLog) =>
                        testLog["mainActivities"] == rowOption["mainActivities"]

                    );
                } else {
                    filterLogs = inputLogSet.filter(
                        (testLog) =>
                        testLog["mainActivities"] == rowOption["mainActivities"] &&
                        testLog["subActivities"] == rowOption["subActivities"]
                    );
                }

                filterLogs = filterLogs.filter((testLog) =>
                    testLog[rowOption["fixedOptions"]] == subOption

                )

                // console.log("filter logs ", filterLogs)
                const cellValue = allCalculations(filterLogs, rowOption["output"])
                cellValues.push(cellValue)


            });
            // console.log("result ", rowOption, cellValues)
            rowColumn.push({ "rowOption": rowOption, "cellValues": cellValues, "fixedSuboption": subOption })
        });

    });

    return rowColumn
        // console.log(rowColumn)

}


const allScaledCalculations = (filteredLogs, option) => {
    let totalScore = 0
    let totalMins = 0
    filteredLogs.forEach(filteredLog => {
        const startTime = moment.unix(filteredLog.startTimestamp);
        const endTime = moment.unix(filteredLog.endTimestamp);
        const diff = Math.round(
            moment.duration(endTime.subtract(startTime)).asMinutes()
        );
        totalMins += diff
        totalScore += (diff * filteredLog[option])
    });

    return Math.round(totalScore / totalMins)

}

const calculateScaledRowData = (inputLogs, rowOptions) => {
    let rowColumn = []
    rowOptions.forEach(rowOption => {
        let cellValues = []
        inputLogs.forEach(inputLogSet => {
            let filterLogs = []
            if (rowOption["subActivities"] == "total") {

                filterLogs = inputLogSet.filter(
                    (testLog) =>
                    testLog["mainActivities"] == rowOption["mainActivities"]
                );


            } else {
                filterLogs = inputLogSet.filter(
                    (testLog) =>
                    testLog["mainActivities"] == rowOption["mainActivities"] &&
                    testLog["subActivities"] == rowOption["subActivities"]
                );
            }

            const cellValue = allScaledCalculations(filterLogs, rowOption["scaledOptions"])
            cellValues.push(cellValue)


        });
        rowColumn.push({ "rowOption": rowOption, "cellValues": cellValues })
    });

    return rowColumn

}










const colorScheme = [
    "#25CCF7",
    "#FD7272",
    "#54a0ff",
    "#00d2d3",
    "#1abc9c",
    "#2ecc71",
    "#3498db",
    "#9b59b6",
    "#34495e",
    "#16a085",
    "#27ae60",
    "#2980b9",
    "#8e44ad",
    "#2c3e50",
    "#f1c40f",
    "#e67e22",
    "#e74c3c",
    "#ecf0f1",
    "#95a5a6",
    "#f39c12",
    "#d35400",
    "#c0392b",
    "#bdc3c7",
    "#7f8c8d",
    "#55efc4",
    "#81ecec",
    "#74b9ff",
    "#a29bfe",
    "#dfe6e9",
    "#00b894",
    "#00cec9",
    "#0984e3",
    "#6c5ce7",
    "#ffeaa7",
    "#fab1a0",
    "#ff7675",
    "#fd79a8",
    "#fdcb6e",
    "#e17055",
    "#d63031",
    "#feca57",
    "#5f27cd",
    "#54a0ff",
    "#01a3a4",
];

// var myLineChart = new Chart(ctx, config);


const graph = (data) => {

    document.getElementById("logsChart").remove()

    let newCanvas = document.createElement('canvas');
    newCanvas.id = "logsChart"
        // console.log(newCanvas)
    document.getElementById("canvasDiv").appendChild(newCanvas)
        // canvas.appendChild(newCanvas)

    const test = new Chart(document.getElementById("logsChart"), {
        type: 'line',
        data: data,
        options: {
            title: {
                display: true,
                text: 'World population per region (in millions)'
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',

                    // grid line settings
                    grid: {
                        drawOnChartArea: false, // only want the grid lines for one axis to show up
                    },
                },
            }
        }
    });

    test.update()
}

const createDataSets = (actData, fixedData, scaledData) => {
    let colourCount = 0
    console.log("fucking go")
    console.log(fixedData)
    let data = {}
    data["labels"] = headers.map(function(header) {
        return header.columnHeader + " " + header.experiment
    })
    let datasets = []
    actData.forEach((actDat, index) => {
        let dataset = {}
        dataset["label"] = actDat.rowOption.mainActivities + " " + actDat.rowOption.subActivities + " " + actDat.rowOption.output
        dataset["data"] = actDat.cellValues
        dataset["backgroundColor"] = colorScheme[index]
        dataset.borderColor = colorScheme[index]
        if (actDat.rowOption.output == logCount) {
            dataset.yAxisID = "y1"
        } else {
            dataset.yAxisID = "y"

        }
        // yAxisID: 'y1',

        colourCount += 1
        datasets.push(dataset)
    });

    fixedData.forEach((fixedDat, index) => {
        let dataset = {}
        dataset["label"] = fixedDat.rowOption.fixedOptions + " " + fixedDat.fixedSuboption + " " + fixedDat.rowOption.mainActivities + " " + fixedDat.rowOption.subActivities + " " + fixedDat.rowOption.output
        dataset["data"] = fixedDat.cellValues
        dataset["backgroundColor"] = colorScheme[index]
        dataset.borderColor = colorScheme[index]
        if (fixedDat.rowOption.output == logCount) {
            dataset.yAxisID = "y1"
        } else {
            dataset.yAxisID = "y"

        }
        // yAxisID: 'y1',

        colourCount += 1
        datasets.push(dataset)
    });

    scaledData.forEach((scaledDat, index) => {
        let dataset = {}
        dataset["label"] = scaledDat.rowOption.scaledOptions + " " + scaledDat.rowOption.mainActivities + " " + scaledDat.rowOption.subActivities + " " + scaledDat.rowOption.output
        dataset["data"] = scaledDat.cellValues
        dataset["backgroundColor"] = colorScheme[index]
        dataset.borderColor = colorScheme[index]
        dataset.yAxisID = "y1"

        // yAxisID: 'y1',

        colourCount += 1
        datasets.push(dataset)
    });



    data["datasets"] = datasets
    console.log(headers)
    console.log(data)
    graph(data)

}


///// input that makes the graph
document.getElementById("make graph").addEventListener("click", event => {
    getColumnHeaders()
    console.log("header zijn ", headers)
    const seperatedLogs = divideLogs()
    console.log("seperated logs ", seperatedLogs)
    const rowOptions = getRowData()
    console.log("row data", rowOptions)
    const actData = calculateActivitiesRowData(seperatedLogs, rowOptions["activityOptions"])

    const fixedData = calculateFixedRowData(seperatedLogs, rowOptions["fixedOptions"])

    const scaledData = calculateScaledRowData(seperatedLogs, rowOptions["scaledOptions"])
    createDataSets(actData, fixedData, scaledData)
    console.log("scaledData")
    console.log(scaledData)
    console.log("fixedData")
    console.log(fixedData)
    console.log("actData")
    console.log(actData)
})

const changeStartEndDate = () => {

    const startDate = document.getElementById("startDate")
    const endDate = document.getElementById("endDate")
    startDate.value = moment().format("YYYY-MM-DD")
    endDate.value = moment().add(1, "day").format("YYYY-MM-DD")

}

changeStartEndDate()

// mainActivities: "rusten"
// output: "total time"
// subActivities: "total