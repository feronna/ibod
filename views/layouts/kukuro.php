<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
<script src="https://kukuro.ums.edu.my/botman/js/widget.js" type="text/javascript"></script>

<script>
    var url_http = "https://kukuro.ums.edu.my";

    var botmanWidget = {
        title: 'Kukuro Web Chat',
        chatServer: url_http + '/smpassistant',
        frameEndpoint: url_http + '/botman/chat',

        introMessage: "Hi there, i am Kukuro your intelligent virtual assistant.\n" +
            "I am glad to attend to all your queries.Please be patient as" +
            "I'm continuously learning to serve you better.",
        aboutText: '',
        bubbleAvatarUrl: "https://www.ums.edu.my/v5/images/kukuro_h.png",
        // bubbleAvatarUrl: "https://kukuro.ums.edu.my/img/kukuro_full_body.png",
        alwaysUseFloatingButton: true,
        displayMessageTime: true

    }

    $(function() {

        $.iGrowl({
            title: 'Hi I am Kukuro',
            message: 'How may I help you?',
            small: true,
            placement: {
                y: 'bottom'
            },
            offset: {
                x: 140,
                y: 150
            }
        });

        $(".chat").on('click', function() {
            botmanChatWidget.open();
        });
    });
    
</script>