config menu om te bepalen welke data je wilt zien

1: date range -> de data waarvan je de tabel wilt generenen
2: dag, week, month selectie --> dag elke column is de data van 1 dag, week, elke column is de data van 1 week
3: main sub activitie data selectie/ 






(dag:log count, total time, average time per log)
(week: is dag opties plus average daily log count, average daily total time, average daily time per log)
()


log count,total time, average time per log ---> accept een array of logs en bepaald deze sizzle, dit kan daily,week,monthly zijn

averate daily log count, average daily total time, average daily time per log --> accept een array of logs divide deze in week data en berekend dan 

column time selection =  day

werken, programmeren, log count
huishouden,schoonmaken, toilet, total time

je hebt ook nog totaal


1:filter logs voor date range
2:seperate logs for daily,weekly,monthly
3: run door de opties voor activities, fixed,scaled

actitivities: daily
werken ->total --> is alle logs pakken
werken ->programmeren --> alleen alle programmeren logs pakken
de logs per dag verdelen in arrays
bereken ->total mins, average time per log, log count

activities weekly
werken ->total --> is alle logs pakken
werken ->programmeren --> alleen alle programmeren logs pakken
de logs per week verdelen, logs per dag verdelen
bereken -> total mins,average time per log, log count.
bereken -> aantal dagen gewerkt deze week
bereken -> average daily total mins, average daily averige time per log, average daily log count

activities weekly
werken ->total --> is alle logs pakken
werken ->programmeren --> alleen alle programmeren logs pakken
de logs per week verdelen, logs per dag verdelen
bereken -> total mins,average time per log, log count.
bereken -> aantal dagen gewerkt deze week
bereken -> average daily total mins, average daily averige time per log, average daily log count
bereken-> aantal weken gewerkt deze maand
bereken -> average daily total mins, average daily averige time per log, average daily log count



function determineNrDaysWeeksWorkedOfLog(logs):

    return daysWorked,weeksWorked


1:function filterLogsForDataRange(logs,startDate,endDate): // dit doet laravel voor me
    return logs


3:function divideLogsForDateInteral([daily,weekly,monthly],logs):

    return array [date/weeknr/month: [logs]]


2:function filterLogsForMainAndSubActivity(mainAct,subAct):
    if subAct == total:
        filter only for mainAct
    else:
        filter for main and subAtc

    return logs

4: functionCalculateData(output option,dividedLogs):
   

    dateRangeArrayValues = []

    foreach dividedLog in in dividedLogs

    totalMins
        aveLogTime
        logCount
        aveDailyTotalMins
        aveDailyLogCount
        aveWeeklyTotalMins
        aveWeeklyLogCount

    
        calc totalmins,avelogtime,log count

    if output option == daily average log time, daily averag log count:
        calc aveDailyTotalMins, aveDailyLogCount
        use determineNrDaysWeeksWorkedOfLog(logs)

    if output option == weelly average log time weekly aveage log count
        calc aveweekltotalmins, aveweeklylogcount
        use determineNrDaysWeeksWorkedOfLog(logs)


    dateRangeArrayValues.push(ouput option value)

    return ouputoption,dateRangeArrayValues


function calcFixedOutput(output option,dividedlogs):
    houding heeft 3 values, liggen,zitten,staan
    filter de array for elke van deze 3 dus je hebt dan 3 arrays en daar calc je dan
    de sizzle van
    functionCalculateData(output option,dividedLogs)

    
function calcScaledOutput():
    aveLevel;

    foreach logSet in logSets:
        calc de average level pijn geluk level 

    return dit



---activities

functin getActivitiesData

filterLogsForDataRange(logs,startDate,endDate)
divideLogsForDateInteral([daily,weekly,monthly],logs)
allActivitesTableData = []
foreach Activities option
    filterLogsForMainAndSubActivity(mainAct,subAct)
    functionCalculateData(output option,dividedLogs)


return allactivitiesTAbleData


function fixed:
    filterLogsForDataRange(logs,startDate,endDate)
    divideLogsForDateInteral([daily,weekly,monthly],logs)
    foreach fixe doption
        filterLogsForMainAndSubActivity(mainAct,subAct)
        calcFixedouput


function scaled:
   filterLogsForDataRange(logs,startDate,endDate)
    divideLogsForDateInteral([daily,weekly,monthly],logs)
    foreach sacled option
    filterLogsForMainAndSubActivity(mainAct,subAct)
    calcScaledOutput


