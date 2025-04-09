document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript Loaded!");

    document.querySelectorAll(".person-view").forEach(person => {
        person.addEventListener("click", function () {
            const nameElement = this.querySelector("h5");
            const imageElement = this.querySelector("img");
            const statusElement = this.querySelector(".text-muted");

            if (!nameElement || !imageElement || !statusElement) {
                console.warn("One or more elements are missing inside .person-view");
                return;
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

            console.log(`Chat switched to: ${name}`);

            fetchmessages(); // Load previous messages instantly

            if (window.chatInterval) {
                clearInterval(window.chatInterval); // Clear previous interval
            }
            window.chatInterval = setInterval(fetchmessages, 1000); // Fetch messages every second
        });
    });
});

function fetchmessages() {
    var sender = $('#sender').val();
    var receiver = $('#receiver').val();
    var chatView = $('#chat-view');
    var isAtBottom = chatView.scrollTop() + chatView.innerHeight() >= chatView[0].scrollHeight - 10;

    $.ajax({
        url: 'fetch_messages.php',
        type: 'POST',
        data: { sender: sender, receiver: receiver },
        success: function (data) {
            $('#chat-view').html(data);
            if (isAtBottom) {
                scrollChatToBottom(); // Scroll only if the user was already at the bottom
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching messages:', error);
        }
    });
}


function scrollChatToBottom() {
    var chatView = $('#chat-view');
    chatView.scrollTop(chatView.prop("scrollHeight"));
}

$(document).ready(function () {
    fetchmessages(); // Load messages when the page loads

    // Submit the chat message
    $('#chat-form').submit(function (e) {
        e.preventDefault();

        var sender = $('#sender').val();
        var receiver = $('#receiver').val();
        var message = $('#message').val();

        if (message.trim() === "") {
            alert("Cannot send empty messages or spaces.");
            return;
        }

        console.log("Sending Data:", { sender: sender, receiver: receiver, message: message });

        $.ajax({
            url: 'submit_messages.php',
            type: 'POST',
            data: { sender: sender, receiver: receiver, message: message },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#message').val('');
                    fetchmessages(); // Fetch new messages instantly
                } else {
                    console.error("Message submission failed:", response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('Message submission failed:', error);
            }
        });
    });
    
    // Auto-fetch messages every second
    setInterval(fetchmessages, 1000);
});
