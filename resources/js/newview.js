import moment from 'moment';
import Chart from "chart.js/auto";

// all js function used for Dashboard functionaltity
//1: seperate functions belonging to timer and graphing of statistics to their own files
//2: use jstest next time.

// list of colors, might not be long enough if the used index is longer than its length
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

// convert data to chart.js format (label,data,backgroundcolor)
const graphDatasets = (data, dataOfInterest) => {

    let datasets = []
    data.forEach((dat, index) => {
        let entry = {}
        entry["label"] = dataOfInterest + " " + dat['label']
        entry["data"] = dat[dataOfInterest]
        entry['backgroundColor'] = colorScheme[index]
        datasets.push(entry)
    });
    return datasets
}

// create the graph
const makeGraph = (columns, labels) => {
    var ctx = document.getElementById("chart");

    var myChart = new Chart(ctx, {
        type: "bar",

        data: {
            labels: labels,
            datasets: columns,
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: "Chart.js Bar Chart - Stacked",
                },
            },
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,


                },


            }
        }
    });

}


// calculate from the logs the total time in minutes worked for each found sub Activity for each
// found main Activity. e.g werken mainActivity has 8 logs with that mainActivity. 5 of these logs has the same subActivity (programmeren),
// the other 3 has another subActivity (onderzoek). Then all the log time for both subActivities are summed.
const makeStatisticGraph = () => {

    // function that calculates for each mainActivity for all subActivities the total time
    const calcSubMainActivitiesTime = (mainActivities, subActivities) => {
        const labels = mainActivities;
        const data = []
        subActivities.forEach(subActivity => {
            let allMins = [] // only total mins is used hower allCounts andor averageMinPerLog can be used also in the future
            let allCounts = []
            let averageMinPerLog = []
            mainActivities.forEach(mainActivity => {
                let seconds = 0
                let counts = 0

                logs.forEach(log => {

                    const cleanLog = log["log"]
                    if (cleanLog["mainActivities"] == mainActivity && cleanLog["subActivities"] == subActivity) {
                        const startTime = cleanLog["startTimestamp"]
                        const endTime = cleanLog["endTimestamp"]
                        const diff = endTime - startTime
                        seconds += diff
                        counts += 1


                    }



                });
                const mins = Math.round(seconds / 60)
                allMins.push(mins)
                allCounts.push(counts)

            });
            allMins.forEach((min, index) => {
                averageMinPerLog.push(Math.floor(min / allCounts[index]))
            });
            data.push({ "logCount": allCounts, "averageMinsPerLog": averageMinPerLog, "totalMins": allMins, "label": subActivity })


        });
        return [data, labels]
    }

    // retrieve for all logs the unique main/ sub Activity names
    const getAllColumnValues = (columnName) => {
        let allValues = []
        logs.forEach(log => {
            const columnValue = log["log"][columnName]
            allValues.push(columnValue)

        });
        let singles = Array.from(new Set(allValues));
        return singles
    }

    // not all mainActivities/subActivities will be done each day. Therefore
    // it makes no sense to graph all these combinations. Therefore first retrieve
    // all used mainActivities and subActivties.
    const logsMainActivities = getAllColumnValues("mainActivities")

    const logsSubActivities = getAllColumnValues("subActivities")
    const data = calcSubMainActivitiesTime(logsMainActivities, logsSubActivities)

    const mainSubActColumns = graphDatasets(data[0], "totalMins")
    makeGraph(mainSubActColumns, data[1])





}


makeStatisticGraph()

// function that updates the timer.

const timer = () => {

    if (timerRunning == true) {
        var startTimestamp = moment(startTimestampIn * 1000);

        setInterval(function() {


            var currentTimestamp = moment(moment.now());
            var diff = currentTimestamp.diff(startTimestamp, 'minutes');
            var hours = Math.floor(diff / 60);
            var mins = diff - (hours * 60);

            var hoursString = ""
            var minsString = ""
            if (hours < 10) { // check if the current hour is single or double digit
                hoursString = "0" + hours.toString()
            } else {
                hoursString = hours.toString()

            }

            if (mins < 10) { // check if the current min is single or double digit
                minsString = "0" + mins.toString()
            } else {
                minsString = mins.toString()

            }


            document.getElementById("timer").innerHTML = hoursString + ":" + minsString;
        }, 1000);
    }

}


timer()