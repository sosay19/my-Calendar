
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Create event</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="Lib/jquery-3.1.1.min.js" type="text/javascript"></script>
        <link href="lib/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href='lib/fullcalendar-3.4.0/fullcalendar.min.css' rel='stylesheet' />
        <link href="lib/jquery-ui-themes-1.12.1/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" />
        <script src="lib/jquery.js"></script>
        <script src="lib/moment.js"></script>
        <script src="Lib/fullcalendar-3.4.0/fullcalendar.min.js" type="text/javascript"></script>
        <script src="lib/jquery-ui-1.12.1/jquery-ui.min.js"></script>
        <script src="lib/jquery-ui-1.12.1.ui-lightness/jquery-ui.min.js" type="text/javascript"></script>
        <script src="Lib/jquery-validation-1.16.0/jquery.validate.min.js" type="text/javascript"></script>

        <script>
            $.validator.addMethod("idcalendarRule", function (value, element, pattern) {
                if (value !== '0')
                    return true;
                else
                    return false;

            }, "Please enter a valid input.");

            $.validator.addMethod("regex", function (value, element, pattern) {
                if (pattern instanceof Array) {
                    for (p of pattern) {
                        if (!p.test(value))
                            return false;
                    }
                    return true;
                } else {
                    return pattern.test(value);
                }
            }, "Please enter a valid input.");

            $.validator.addMethod("checkDate", function (value, element, pattern) {
                if (document.getElementById("DatestartC").value <= document.getElementById("DatefinishC").value)
                {
                    return true;
                } else
                    return false;
            }, "Please enter a valid input.");

        $.validator.addMethod("checkTime", function (value, element, pattern) {
                if (document.getElementById("DatestartC").value == document.getElementById("DatefinishC").value) {
                    if (document.getElementById("TimestartC").value < document.getElementById("TimefinishC").value)
                    {
                        return true;
                    } else
                        return false;

                } else if (document.getElementById("DatestartC").value < document.getElementById("DatefinishC").value) {
                    return true;
                }

            }, "Please enter a valid input.");

            $(function () {
                $("#eventForm").validate({
                    rules: {
                        titleC: {
                            required: true,
                            minlength: 2,
                            maxlength: 16
                        },
                        idcalendarC: {
                            required: true,
                            idcalendarRule: 0
                        },
                        descriptionC: {
                            required: true,
                            maxlength: 500
                        },
                        DatestartC: {
                            required: true
                        },
                        DatefinishC: {
                            required: true,
                            checkDate: ""
                        },
                        TimestartC: {
                            required: true
                        },
                        TimefinishC: {
                            required: true,
                            checkTime: ""
                        }
                    },
                    messages: {
                        titleC: {
                            required: 'specify title',
                            minlength: 'minimum 2 characters',
                            maxlength: 'maximum 16 characters'
                        },
                        idcalendarC: {
                            required: 'specify a calendar',
                            idcalendarRule: 'please select a calendar'

                        },
                        descriptionC: {
                            required: 'specify description',
                            maxlength: 'maximum 500 characters'
                        },
                        DatestartC: {
                            required: 'specify start'
                        },
                        DatefinishC: {
                            required: 'specify finish',
                            checkDate: 'dateFinish doit être plus grande que dateStart'
                        },
                        TimestartC: {
                            required: 'specify start'
                        },
                        TimefinishC: {
                            required: 'specify finish',
                            checkTime: 'timeFinish doit être plus grand que timeStart'
                        }

                    }
                });
                $("input:text:first").focus();
            });
            var whole_day, Timestart, Datestart, Timefinish, Datefinish, errStart, errFinish;
            document.onreadystatechange = function () {
                if (document.readyState === 'complete') {
                    whole_day = document.getElementById("whole_dayC");
                    Timestart = document.getElementById("TimestartC");
                    Timefinish = document.getElementById("TimefinishC");
                    Datestart = document.getElementById("DatestartC");
                    Datefinish = document.getElementById("DatefinishC");
                    errStart = document.getElementById("errStartC");
                    errFinish = document.getElementById("errFinishC");
                }
            };
            function onChanged(field)
            {
                var checked = whole_day.checked;
                if (checked === true)
                {
                    Timestart.disabled = true;
                    Timefinish.disabled = true;
                    Timestart.hidden = true;
                    Timefinish.hidden = true;
                } else
                {
                    Timestart.disabled = false;
                    Timefinish.disabled = false;
                    Timestart.hidden = false;
                    Timefinish.hidden = false;
                }
            }

        </script>
    </head>
    <body>
        <div class="title">Create event!</div>
        <?php include('menu.html'); ?>
        <div class="main">

        </div>
        <a href="http://localhost/prwb_1617_G13/Planning/index">Back</a>
        <form id="eventForm" name="CreateEventForm" action="planning/create_Aevent" method="post">
            <table>
                <tr>
                    <td>Title :</td>

                    <td><textarea id="titleC" name="titleC" rows='1'></textarea></td>
                </tr>
                <tr>
                    <td>calendar :</td>
                    <td><select id="idcalendarC" name="idcalendarC" >
                            <option value="0" hidden >Select a calendar</option>
                            <?php foreach ($calendars_shares as $calendars_share): ?>
                                <?php if (Share::get_share($calendars_share->idcalendar, $user->iduser) != null): ?>
                                    <?php if ((Share::get_share($calendars_share->idcalendar, $user->iduser)->read_only == 0)) : ?>

                                        <option style="color:#<?= $calendars_share->color ?>" value="<?= $calendars_share->idcalendar ?>"><font color="#<?= $calendars_share->color ?>"><?= $calendars_share->description ?></font>

                                        </option>

                                    <?php endif; ?>
                                <?php elseif (Share::get_share($calendars_share->idcalendar, $user->iduser) == null): ?>
                                    <option style="color:#<?= $calendars_share->color ?>" value="<?= $calendars_share->idcalendar ?>"><font color="#<?= $calendars_share->color ?>"><?= $calendars_share->description ?></font>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select></td>
                </tr>
                <tr>
                    <td>Description :</td>
                    <td><textarea id="descriptionC"  name="descriptionC"  rows='4'></textarea></td>
                </tr>
                <tr>
                    <td>Start time:</td> 
                    <td><input id="DatestartC" class="date" name="DatestartC" type="date"  value="" ></td>
                    <td><input id="TimestartC" class="time" name="TimestartC" type="time"   ></td>
                </tr>
                <tr>
                    <td>Finish time:</td>
                    <td><input id="DatefinishC" class="date" name="DatefinishC" type="date"   ></td>
                    <td><input id="TimefinishC" class="time" name="TimefinishC" type="time"   ></td>                            
                </tr>
                <tr>
                    <td><input id="whole_dayC" name="whole_dayC" type="checkbox" onchange="onChanged(this);">Whole day event<br></td>
                </tr>
                <input id="ideventC" type='text' name='ideventC' value=""   hidden="">
            </table>
            <input id="create" type="submit" name = "create" value="create" >
        </form>
    </div>
</body>
</html>
