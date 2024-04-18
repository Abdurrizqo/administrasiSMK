function scrollToBottom() {
    document.documentElement.scrollTop = document.documentElement.scrollHeight;
}

window.onload = function () {
    scrollToBottom();
};

function getFileName(filePath) {
    var parts = filePath.split('/');
    var fileName = parts[parts.length - 1];

    return fileName;
}

const idDisposisi = document.getElementById("idDisposisi").value;
const chatContainer = document.getElementById("chatContainer");

function addChatMessage(message, userIdResponse, file) {
    const userId = document.getElementById("userId").value;

    const chatClass = userIdResponse === userId ? 'chat-end' : 'chat-start';
    let fileDownloadLink = null;
    if (file) {
        file = getFileName(file);
        fileDownloadLink = `/download-file/message/${file}`;
    }

    const chatElement = document.createElement('div');
    chatElement.classList.add('chat', chatClass);

    const chatBubbleElement = document.createElement('div');
    chatBubbleElement.classList.add('chat-bubble', 'text-xs', 'lg:text-base');

    if (fileDownloadLink) {
        const downloadLinkElement = document.createElement('a');
        downloadLinkElement.setAttribute('target', '_blank');
        downloadLinkElement.setAttribute('href', fileDownloadLink);
        downloadLinkElement.classList.add('bg-gray-600', 'p-4', 'rounded-lg', 'w-36', 'w-full', 'mb-5', 'flex', 'gap-2', 'justify-start', 'items-center');

        const iconElement = document.createElement('span');
        iconElement.classList.add('material-icons', 'text-white');
        iconElement.textContent = 'description';

        const textElement = document.createElement('p');
        textElement.classList.add('text-white', 'poppins-medium');
        textElement.textContent = 'Download';

        downloadLinkElement.appendChild(iconElement);
        downloadLinkElement.appendChild(textElement);

        chatBubbleElement.appendChild(downloadLinkElement);
    }

    const messageElement = document.createElement('div');
    messageElement.textContent = message;
    chatBubbleElement.appendChild(messageElement);

    chatElement.appendChild(chatBubbleElement);

    chatContainer.appendChild(chatElement);

    scrollToBottom(chatContainer);
}

Echo.private(`chat.${idDisposisi}`)
    .listen('SendMessage', (e) => {
        addChatMessage(e.message, e.pegawai.idPegawai, e.file);
    })