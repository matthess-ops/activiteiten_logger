import moment from 'moment';
console.log("cur time ", moment.now());


if (timerRunning == false) {
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

        document.getElementById("timer").innerHTML = hoursString + ":" + minsString;
    }, 1000);
}