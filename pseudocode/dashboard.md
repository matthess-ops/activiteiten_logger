timer

databases

table timer_data

$table->json('currentSelections'); currentSelections can be changed by suggestions and user input

$table->json('main_activities');//user generated
$table->json('sub_activities_');//user generated
$table->json('scaled_options');//user generated
$table->json('fixed_options');//user generated
$table->json('experiments');//user generated
$table->json('suggestions'); // either user generated or by th programm itself
$table->json('previousLog'); // consists of timestamp and all the values.
(is timer running)


TimerController()


readTimerData():
    read all timer_data table and pass this to the view


startTimer() // timer run button
    updates previous logs with the form data
    update the currentSelection with the form data
    redirect

updateSelection() // the suggestions buttons
        update the currentSelection with the suggestions form data
        redirect


view

consists of two columns one of 4 and 1 of 8

col 4
form
row 1: timer h3, input button
then each row contains the various buttons and stuff

col 8:







