/**
 * Created by Chris on 30/08/2015.
 */



function getData(){
    $.ajax({
        type: "GET",
        url: "index.php?action=getfriends",
        success: function(xml){

            deleteAllChildren("friends");

            var friendDiv = $("#friends");

            $(xml).find("username").each(function(){

                var friendName = $(this).text();

                var aFriend = $('<a></a>')
                    .attr({href : "index.php?action=chat&user=" + friendName})
                    .text(friendName)
                    .append($('<br>'));

                friendDiv.append(aFriend);



            })

            setTimeout("getData()", 2000);
        }
    })
}

function sendMessage(){
    // What variables do we need
    var chatID = $("#chatid").val();
    console.log("chat id: " + chatID);
    $.ajax({
        type : "POST",
        url : "index.php?action=sendmessage",
        data : {
            chatID : chatID,
            message : $("#message").val()
        },
        dataType : "text",
        success: function(){
            $("#message").val("");
        }
    })
}

var xmlChildren = 0;
var firstTime = true;
function getMessages(){

    $.ajax({
        type : "GET",
        url : "index.php?action=getmessages&chatid="+$("#chatid").val(),
        success : function(xml){

            // Check for amount of children;

            deleteAllChildren("chatarea");

            $(xml).find("message").each(function(){
                var paraText = $(this).text();
                var para = $('<p></p>')
                    .text(paraText);
                $("#chatarea").append(para);
            });

            var currentLength = ($(xml).find("message").length);

            if(firstTime){
                xmlChildren = currentLength;
                firstTime = false;
            }

            if(currentLength > xmlChildren && xmlChildren != 0){
                // Logic
                goBottom();

                xmlChildren = currentLength;
            }

            setTimeout(getMessages,1000);
        }
    })

}

// Capture keyboard input
function setup(){

    $("#messagearea").keydown(function (key){
        if(key.keyCode == 13){
            sendMessage();
        }
    });

    getMessages();
}



// Helper functions (mainly for UI)

function deleteAllChildren(parent) {
    /*var myNode = document.getElementById(parent);
    while(myNode.firstChild){
        myNode.removeChild(myNode.firstChild);
    }*/

    $("#"+parent).empty();
}

// Vertically Align
function valign(element, amount){

    if(amount === undefined){
        amount = 2;
    }

    var elementHeight = $(element).height();
    var pageHeight = $(document).height();

    var emptySpace = pageHeight - elementHeight;
    var margin = emptySpace / amount;

    $(element).css("margin-top", margin);
}

// Goes to the bottom of the div
function goBottom(){
    var chatArea = $("#chatarea");
    chatArea.scrollTop(chatArea[0].scrollHeight);
}