document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript Loaded!");

    document.querySelectorAll(".person-view").forEach(person => {
        person.addEventListener("click", function () {
            const nameElement = this.querySelector("h5");
            const imageElement = this.querySelector("img");
            const statusElement = this.querySelector(".text-muted");

            if (!nameElement || !imageElement || !statusElement) {
                console.warn("One or more elements are missing inside .person-view");
                return; // Stop execution if required elements are missing
            }

            const name = nameElement.textContent;
            const imageSrc = imageElement.src;
            const statusHTML = statusElement.innerHTML;

            const chatName = document.getElementById("chat-name");
            const chatImage = document.getElementById("chat-image");
            const chatStatus = document.getElementById("chat-status");

            if (chatName) chatName.textContent = name;
            if (chatImage) chatImage.src = imageSrc;
            if (chatStatus) chatStatus.innerHTML = statusHTML;

            console.log(`Chat switched to: ${name,imageSrc}`);
        });
    });
});


function fetchmessages(){
    var sender=$('#sender').val();
    var receiver=$('#receiver').val();

    $.ajax({
        url:'fetch_messages.php',
        type:'POST',
        data:{sender:sender,receiver:receiver},
        success: function(data){
            $('#chat-view').html(data);
            scrollChatToBottom();
        },
        error: function (xhr, status, error) {
            console.error('Error fetching messages:', error);
        }
    });
}

function scrollChatToBottom(){
    var chatView=$('#chat-view');
    chatView.scrollTop(chatView.prop("scrollHeight"));
}


$(document).ready(function(){
    //fetch messages every 3 seconds

    fetchmessages();
    setInterval(fetchmessages,3000);
});

//submit the chat message
$('#chat-form').submit(function(e){
    e.preventDefault();
    
    var sender=$('#sender').val();
    var receiver=$('#receiver').val();
    var message=$('#message').val();

    if (message.trim() === "") {
        alert("Cannot send empty messages or spaces.")
        return; // Do not send empty messages
    }
    
    console.log("Sending Data:", { sender: sender, receiver: receiver, message: message });

    $.ajax({    
        url:'submit_messages.php',
        type:'POST',
        data:{sender:sender,receiver:receiver, message:message},
        success: function(){
            $('#message').val('');
            fetchmessages();
        },
        error: function (xhr, status, error) {
            console.error('Message submission failed:', error);
        }
    });
});

