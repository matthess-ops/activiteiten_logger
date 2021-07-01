import moment from 'moment';
import Chart from "chart.js/auto";


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

const graphDatasets = (data, dataOfInterest) => {
    // label: 'Low',
    // data: [67.8],
    // backgroundColor: '#D6E9C6',
    let datasets = []
    data.forEach((dat, index) => {
        console.log("dat ", dat)
        let entry = {}
        entry["label"] = dataOfInterest + " " + dat['label']
        entry["data"] = dat[dataOfInterest]
        entry['backgroundColor'] = colorScheme[index]
        datasets.push(entry)



    });
    return datasets
}


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

const makeStatisticGraph = () => {

    const calcSubMainActivitiesTime = (mainActivities, subActivities) => {
        const labels = mainActivities;
        const data = []
        subActivities.forEach(subActivity => {
            let allMins = []
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

    const getAllColumnValues = (columnName) => {
        let allValues = []
        logs.forEach(log => {
            const columnValue = log["log"][columnName]
            allValues.push(columnValue)

        });
        let singles = Array.from(new Set(allValues));
        return singles
    }

    const logsMainActivities = getAllColumnValues("mainActivities")
    const logsSubActivities = getAllColumnValues("subActivities")
    const data = calcSubMainActivitiesTime(logsMainActivities, logsSubActivities)

    const mainSubActColumns = graphDatasets(data[0], "totalMins")
    makeGraph(mainSubActColumns, data[1])



}
makeStatisticGraph()

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
            if (hours < 10) {
                hoursString = "0" + hours.toString()
            } else {
                hoursString = hours.toString()

            }

            if (mins < 10) {
                minsString = "0" + mins.toString()
            } else {
                minsString = mins.toString()

            }
            // console.log(hoursString + ":" + minsString);
            // document.getElementById("timer").innerHTML = "00:00";

            document.getElementById("timer").innerHTML = hoursString + ":" + minsString;
        }, 1000);
    }

}


timer()