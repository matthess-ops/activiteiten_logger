// make test here, because alot of calculations are done here.
// additional function for now only row options can be added, they cannot be removed

import moment from 'moment';
import Chart from "chart.js/auto";




// retrieve all blade data for the Activities
let mainActivities = timerData["mainActivities"];
let subActivities = timerData["subActivities"];
let fixedOptions = timerData["fixedOptions"];
let scaledOptions = timerData["scaledOptions"];
let logs = logss;

// the subActivities will have a total function, meaning that all values of the subActivities are totalled for the mainActivity
subActivities.push("total")

const logCount = "log count"; // nr of logs that has one or more of the needed values e.g mainActivity= "werken", subActivity="programmeren"
const totalTime = "total time"; // the total time of all the logs of the needed values e.g mainActivity= "werken", subActivity="programmeren"
const timePerLog = "time per log"; // the average time per log of the needed values e.g mainActivity= "werken", subActivity="programmeren"
const averageTimePerDay = "daily ave time"; // is the total time divided by 5 days
const averageLogCountPerDay = "daily ave logcount"; // log count divided by 5 days
const averageTimePerWeek = "weekly ave time"; //total time dividied by 4 weeks
const averageLogCountPerWeek = "weekly ave logcount"; // log count divided by 4 weeks


// all the different calculations that are possible for the different output options.
// to determine which outputs are possible is dependant on the timeInterval, e.g it is not
// possible to calculate the averageTimePerWeek if only the logs of one day are selected.
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

// clearing of the rows output
const clearRows = () => {

        document.getElementById("activityRows").textContent = "";
        document.getElementById("fixedRows").textContent = "";
        document.getElementById("scaledRows").textContent = "";

    }
    // get the timerInterval
    // 1: remove duplicated code
const getTimeInterval = () => {


    document.getElementById("day").addEventListener("click", event => {
        timeInterval = "day";
        clearRows()
    });
    document.getElementById("week").addEventListener("click", event => {
        timeInterval = "week";
        clearRows()

    });
    document.getElementById("month").addEventListener("click", event => {
        timeInterval = "month";
        clearRows()

    });
};

getTimeInterval();


//create select and options
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

//creates the mainActivities options select row
// consists of the following select mainActivity select
// subActivity select and output select containing either day,week, month output options
//1: the timerInterval if statements are duplicated uncessary 3 times in other functions.
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

//creates the fixed options select row.
// consists of the following select fixedOptions select, mainActivity select
// subActivity select and output select containing either day,week, month output options
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

//creates the scaled options select row.
// consists of the following select scaled select, mainActivity select
// subActivity select and output select containing either day,week, month output options
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
});


document.getElementById("fixedInput").addEventListener("click", event => {
    createFixedRow();
});

document.getElementById("scaledInput").addEventListener("click", event => {
    createScaledRow();
});

//gets the values of selects of the created rows (activitiesRow,scaledRow, fixedRow)
const getChildElements = (rowName) => {

    let options = []
    const rowChilds = document.getElementById(rowName).childNodes

    rowChilds.forEach(element => {
        const rowChildsElements = element.childNodes //does not only consists of select but also text, these need to be filterd out
        let row = []
        rowChildsElements.forEach(rowChildElement => {
            if (rowChildElement.tagName == "SELECT") {
                row[rowChildElement.id] = rowChildElement.value

            }
        });
        if (Object.keys(row).length != 0) {
            options.push(row)

        }

    });

    return options

}




// collections of all the different rows and its options
const getRowData = () => {

    let rowOptions = {
        "scaledOptions": getChildElements("scaledRows"),
        "fixedOptions": getChildElements("fixedRows"),
        "activityOptions": getChildElements("activityRows")


    }

    return rowOptions





}



// gets the x axis headers. For timeInterval "day" this should be in dates 21-11-21
// for timerInterval "week" this is the weeknr. For timeInterval "month" is the month name
//1: alot of duplicated code, break out in a seperate function
const getColumnHeaders = () => {

        const startDate = moment(dates["startDate"], "YYYY-MM-DD");
        const endDate = moment(dates["endDate"], "YYYY-MM-DD");
        const columnHeaders = []
        if (timeInterval == "day") {
            const diffInDays = endDate.diff(startDate, "days");
            for (let index = 0; index < diffInDays; index++) {
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

        }
        if (timeInterval == "week") {

            const diffInWeeks = endDate.diff(startDate, "week");
            for (let index = 0; index < diffInWeeks; index++) {
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


        }
        if (timeInterval == "month") {
            const diffInMonths = endDate.diff(startDate, "month");
            // // console.log("diff in month ", diffInMonths)
            for (let index = 0; index < diffInMonths; index++) {
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
        }



        headers = columnHeaders;
    }
    // groups the logs per header date.
const divideLogs = () => {
    let newLogs = []
    headers.forEach(header => {
        let tempLogs = []
        logs.forEach(log => {

            if (
                moment.unix(log["log"].startTimestamp).isSameOrAfter(header.startDate) &&
                moment.unix(log["log"].startTimestamp).isBefore(header.endDate)
            ) {
                tempLogs.push(log["log"]);
            }
        });
        newLogs.push(tempLogs)
    });


    return newLogs

}



// function used to calculate the provided option for a group of logs.
const allCalculations = (filteredLogs, option) => {
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


// filter for the date log groups for the needed main and sub activity.
// followed by calculating for each filter date log group the needed output (totalMin, log count etc).
//1: again quite alot of code duplication between this function and calculateFixedRowData() and calculateScaledRowData()
const calculateActivitiesRowData = (inputLogs, rowOptions) => {
        let rowColumn = []
        rowOptions.forEach(rowOption => {
            let cellValues = []
            inputLogs.forEach(inputLogSet => {
                let filterLogs = []
                if (rowOption["subActivities"] == "total") { // total means that all logs containing the mainActivity are needed for the calculation. The result is the sum of all subActivities
                    filterLogs = inputLogSet.filter(
                        (testLog) =>
                        testLog["mainActivities"] == rowOption["mainActivities"]

                    );
                } else {
                    filterLogs = inputLogSet.filter( // is not total, thus the array should be filtered for logs of a particular main and sub activity
                        (testLog) =>
                        testLog["mainActivities"] == rowOption["mainActivities"] &&
                        testLog["subActivities"] == rowOption["subActivities"]
                    );
                }

                const cellValue = allCalculations(filterLogs, rowOption["output"]) // do the calculatuion
                cellValues.push(cellValue)


            });
            rowColumn.push({ "rowOption": rowOption, "cellValues": cellValues })
        });

        return rowColumn
    }
    //the same af with calculateActivitiesRowData() above. Only for each of the fixed options of the fixed Activity 
    // a seperate group is created. E.g fixedActivity = houding / fixedOptions = zitten,staan,liggen. The logs are
    // filtered for total, main and sub activity. And also filter for zitten,staan and liggen. Thus the result is 3 datasets, one for zitten,staan and liggen
const calculateFixedRowData = (inputLogs, rowOptions) => {
        let rowColumn = []
        rowOptions.forEach(rowOption => {

            const subOptions = fixedOptions[rowOption["fixedOptions"]]
            subOptions.forEach(subOption => { // these subOptions are zitten,staan and liggen


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

                    filterLogs = filterLogs.filter((testLog) =>
                        testLog[rowOption["fixedOptions"]] == subOption

                    )

                    const cellValue = allCalculations(filterLogs, rowOption["output"])
                    cellValues.push(cellValue)


                });
                rowColumn.push({ "rowOption": rowOption, "cellValues": cellValues, "fixedSuboption": subOption }) //fixedSuboption is specfici for fixed rows, you need this value because if will become part or the line legend. e.g houding -> zitten-> werken -> programmenen - total time
            });

        });

        return rowColumn
            // console.log(rowColumn)

    }
    //
    //scaled Activities only have one option, which is the average level of all the logs in the group. E.g pijn level average = 5;

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

    return Math.round(totalScore / totalMins) // the average level per minute is calculated and returend

}



//the same af with calculateActivitiesRowData() above.
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


// might not contain enought colours if to many row options are put in one graph
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


// create the graph. Each line in the graph is the calculated results for one of the row options
const graph = (data) => {

    document.getElementById("logsChart").remove() // remove the previous chart/canvas, because chartjs prevent overriding previouly made charts

    let newCanvas = document.createElement('canvas');
    newCanvas.id = "logsChart"
    document.getElementById("canvasDiv").appendChild(newCanvas) // create a new canvas

    const test = new Chart(document.getElementById("logsChart"), {
        type: 'line',
        data: data,
        options: {
            title: {
                display: true,
                text: 'Activities'
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                },
                y1: { // second y axis is needed because total time can be several 100's of minutes while the average pijn level is allways between 0-10. And log count is normally a small value.  Which therefore it becomes difficult to see the change of the average pijn level and log count
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

// converts the calculated data for the activities, fixed activities and scaledActivities 
// to the chartjs format.
//1:  Since a user can change experiments a few times a week. Not all the logs in a date group may represent the first log experiment.
// however this only really a big problem for monthly date groups.
//2: remove duplicated code 

const createDataSets = (actData, fixedData, scaledData) => {
    let colourCount = 0
    console.log(fixedData)
    let data = {}
    data["labels"] = headers.map(function(header) {
        return header.columnHeader + " " + header.experiment // concatenate header (date,week nr or month name) with the experiment.
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

        colourCount += 1
        datasets.push(dataset)
    });

    scaledData.forEach((scaledDat, index) => {
        let dataset = {}
        dataset["label"] = scaledDat.rowOption.scaledOptions + " " + scaledDat.rowOption.mainActivities + " " + scaledDat.rowOption.subActivities + " " + scaledDat.rowOption.output
        dataset["data"] = scaledDat.cellValues
        dataset["backgroundColor"] = colorScheme[index]
        dataset.borderColor = colorScheme[index]
        dataset.yAxisID = "y1" // since scaled data goes from 0 -10 it allways needs to be put on the y1 axis.


        colourCount += 1
        datasets.push(dataset)
    });



    data["datasets"] = datasets
        // console.log(headers)
        // console.log(data)
    graph(data)

}


// is main of making the graph
document.getElementById("make graph").addEventListener("click", event => {
    getColumnHeaders() // creates the date ranges dependent on the timeInterval
    const seperatedLogs = divideLogs() // divides the logs over the date ranges.
    const rowOptions = getRowData() // get the selected options of the mainActivities, fixed and scaled Activities .
        // console.log("row data", rowOptions)
    const actData = calculateActivitiesRowData(seperatedLogs, rowOptions["activityOptions"])

    const fixedData = calculateFixedRowData(seperatedLogs, rowOptions["fixedOptions"])

    const scaledData = calculateScaledRowData(seperatedLogs, rowOptions["scaledOptions"])
    createDataSets(actData, fixedData, scaledData) // convertsthe calculated data to graph format data 
    console.log("scaledData")
    console.log(scaledData)
    console.log("fixedData")
    console.log(fixedData)
    console.log("actData")
    console.log(actData)
})


// changes the start date and end date of the calender date picker today and tomorrow
const changeStartEndDate = () => {

    const startDate = document.getElementById("startDate")
    const endDate = document.getElementById("endDate")
    startDate.value = moment().format("YYYY-MM-DD")
    endDate.value = moment().add(1, "day").format("YYYY-MM-DD")

}

changeStartEndDate()