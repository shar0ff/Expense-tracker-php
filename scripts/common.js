function handleError(message, element) {
    const messageDiv = document.createElement("div");

    const existingMessages = document.querySelectorAll(".error-message");
    existingMessages.forEach((msg) => msg.remove());
  
    messageDiv.className = "error-message";
    messageDiv.textContent = message;
  
    const layoutElement = document.querySelector(element);
    layoutElement.insertBefore(messageDiv, layoutElement.firstChild);  
}