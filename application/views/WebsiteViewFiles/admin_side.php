<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>

    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- http://bootsnipp.com/snippets/4jXW -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/chat.css" />



    <style>
        .chat {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .chat li {
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #B3A9A9;
        }

        .chat li.left .chat-body {
            margin-left: 60px;
        }

        .chat li.right .chat-body {
            margin-right: 60px;
        }


        .chat li .chat-body p {
            margin: 0;
            color: #777777;
        }

        .panel .slidedown .glyphicon,
        .chat .glyphicon {
            margin-right: 5px;
        }

        .panel-body {
            overflow-y: scroll;
            height: 300px;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar-thumb {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #555;
        }

        .live_chat_main {
            position: relative;
        }

        .live_chat_main_1 {
            position: fixed;
            right: 16px;
            bottom: 50px;
            z-index: 100;
            max-width: 350px;
            width: 100%;
            border-radius: 20px;
        }

        .live_chat_main_2 {
            position: fixed;
            right: 16px;
            bottom: 20px;
            z-index: 100;
            max-width: 350px;
            width: 100%;
            border-radius: 20px;
        }

        .panel-primary {
            border-color: black !important;
            border-radius: 20px;
        }

        .panel-primary>.panel-heading {
            color: #fff;
            background-color: black !important;
            border-color: black !important;
            border-radius: 20px;
        }

        .panel-footer {
            padding: 10px 15px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            border-radius: 20px;

        }

        .btn-warning {
            color: #fff;
            background-color: #ef9e2c !important;
            border-color: #ef9e2c !important;
        }

        #panelbody {
            display: block;
        }
    </style>
</head>

<body>
    <div class="live_chat_main">
        <div class=" live_chat_main_1">
            <div id="panelbody">
                <div class="panel panel-primary">
                    <div class="px-2" style="display: flex;justify-content:space-between;align-items: center;">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-comment"></span> Admin Chat
                        </div>
                        <div onclick="chatclose();" style="cursor: pointer;;width: 30px;height: 30px;border-radius: 100%;background-color: white;display: flex;justify-content: center;align-items: center;border: 1px solid black;">
                            <i class="fa fa-close text-black">X</i>
                        </div>
                    </div>
                    <div class="panel-body">
                        <ul class="chat" id="received">

                            <?php foreach ($all_messages as $row) { ?>

                                <li style="text-align: <?= $row->role == 'admin' ? 'right' : 'left'; ?>">
                                    <?= $row->message ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <form action="" method="post" id='add_form'>
                        <div class="panel-footer">
                            <div class="clearfix">
                                <div class="col-md-3" style="display: none;">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Name:
                                        </span>
                                        <input id="name" name="name" type="text" class="form-control input-sm" placeholder="name..." />
                                    </div>
                                </div>
                                <div class="col-md-12" id="msg_block">
                                    <div class="input-group">
                                        <input id="message" name="message" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                                        <span class="input-group-btn">
                                            <button class="btn btn-warning btn-sm" id="submit" onclick="submitForm_to('<?php echo ADMINFUNCTIONS . 'add_message_admin'; ?>','<?php echo ADMIN . 'admin_side' ?>','add_form')">Send</button>
                                        </span>
                                        <!-- <div style="padding: 0px; margin: 20px; line-height: 20px; text-shadow: none; color: white;" id="msgs-add_form"></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="live_chat_main_2">
        <div onclick="chatopen();" style="cursor: pointer;margin-left: auto;padding: 4px;width: 40px;height: 40px;border-radius: 100%;background-color: white;display: flex;justify-content: center;align-items: center;border: 2px solid black;">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-telegram" width="84" height="84" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
            </svg>
        </div>
    </div>

    <script>
        function chatclose() {
            document.getElementById("panelbody").style.display = "none";
        }

        function chatopen() {
            var panelbody = document.getElementById("panelbody");
            if (panelbody.style.display === "block") {
                panelbody.style.display = "none";
            } else {
                panelbody.style.display = "block";
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            var refreshInterval = 10000;

            function refreshContent() {

                $.ajax({
                    url: '<?php echo ADMINFUNCTIONS . 'get_data'; ?>',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('Received data:', data);

                        if (data.success) {

                            $('#received').empty();

                            var messages = data.messages;
                            for (var i = 0; i < messages.length; i++) {
                                var message = messages[i];
                                var li = $('<li></li>').css('text-align', message.role == 'admin' ? 'right' : 'left').text(message.message);
                                $('#received').append(li);
                            }
                        } else {
                            console.error('Server returned an error:', data.message);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error); // Log any errors for debugging
                    }
                });
            }

            // Call refreshContent once initially to load the content when the page loads
            refreshContent();

            // Set up the interval to refresh the content
            setInterval(refreshContent, refreshInterval);
        });
    </script>

</body>

</html>
<?php include('footer.php'); ?>