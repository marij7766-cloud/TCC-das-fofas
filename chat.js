  // Simulação de Mensagens
        let messages = [
            { id: 1, text: "Olá! Vi seu anúncio da camiseta polo. Ainda está disponível?", sender: "other", time: "10:30" },
            { id: 2, text: "Oi! Sim, ainda está disponível. Está em ótimo estado!", sender: "me", time: "10:32" },
            { id: 3, text: "Ótimo! Teria como fazer por R$ 30?", sender: "other", time: "10:33" },
            { id: 4, text: "Posso fazer por R$ 32. Fechamos?", sender: "me", time: "10:35" }
        ];

        const messagesContainer = document.getElementById('messagesContainer');
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const backBtn = document.getElementById('backBtn');
        const sidebar = document.getElementById('sidebar');

        // sla como explicar, mas é tipo o jeito que as mensagens vão
        function renderMessages() {
            messagesContainer.innerHTML = messages.map(msg => `
                <div class="message ${msg.sender}">
                    <div class="message-bubble">
                        <div>${msg.text}</div>
                        <div class="message-time">${msg.time}</div>
                    </div>
                </div>
            `).join('');
            
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Simulando mandar uma mensagem (ela não fica guardada)
        function sendMessage() {
            const text = messageInput.value.trim();
            if (!text) return;

            const time = new Date().toLocaleTimeString('pt-BR', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });

            messages.push({
                id: messages.length + 1,
                text: text,
                sender: 'me',
                time: time
            });

            messageInput.value = '';
            renderMessages();
        }

        sendBtn.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        backBtn.addEventListener('click', () => {
            sidebar.classList.remove('open');
            backBtn.style.display = 'none';
        });

        renderMessages();

        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });