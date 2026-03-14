<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Apex Hardware Supply & Tools</title>

  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <!-- Global styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Page-specific CSS -->
    @yield('extra-css')
</head>
<body>

    <!-- Navigation -->
  @include('layouts.nav')

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
  @include('layouts.footer')

    <!-- Floating chatbot -->
    <div class="chatbot-widget" id="chatbotWidget">
      <div class="chatbot-panel" id="chatbotPanel" aria-hidden="true">
        <div class="chatbot-header">
          <div class="chatbot-title-wrap">
            <span class="chatbot-icon"><i class="fas fa-comments"></i></span>
            <div>
              <div class="chatbot-title">Apex Assistant</div>
              <div class="chatbot-subtitle">Product, stock and order help</div>
            </div>
          </div>
          <button type="button" class="chatbot-minimize" id="chatbotMinimize" aria-label="Minimize chat">
            <i class="fas fa-minus"></i>
          </button>
        </div>

        <div class="chatbot-messages" id="chatbotMessages">
          <div class="chatbot-message bot">Hi! I am Apex Assistant. Ask me about products, stock, and your orders.</div>
        </div>

        <form class="chatbot-input-area" id="chatbotForm">
          <input
            id="chatbotInput"
            class="chatbot-input"
            type="text"
            maxlength="500"
            placeholder="Ask about stock, products, or orders..."
            autocomplete="off"
          >
          <button type="submit" class="chatbot-send" aria-label="Send message">
            <i class="fas fa-paper-plane"></i>
          </button>
        </form>
      </div>

      <button type="button" class="chatbot-toggle" id="chatbotToggle" aria-label="Open chat assistant">
        <i class="fas fa-comment-dots"></i>
      </button>
    </div>

    <!-- Global JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
      (() => {
        const menuToggle = document.getElementById('menuToggle');
        const mainLinks = document.querySelector('.main-links');
        const accountDropdown = document.querySelector('.account-dropdown');

        if (menuToggle && mainLinks) {
          menuToggle.addEventListener('click', (event) => {
            event.stopPropagation();
            mainLinks.classList.toggle('active');
          });

          document.addEventListener('click', (event) => {
            if (!mainLinks.contains(event.target) && !menuToggle.contains(event.target)) {
              mainLinks.classList.remove('active');
            }

            if (accountDropdown && !accountDropdown.contains(event.target)) {
              accountDropdown.classList.remove('active');
            }
          });

          window.addEventListener('resize', () => {
            if (window.innerWidth > 920) {
              mainLinks.classList.remove('active');
            }
          });
        }

        const widget = document.getElementById('chatbotWidget');
        const panel = document.getElementById('chatbotPanel');
        const toggle = document.getElementById('chatbotToggle');
        const minimize = document.getElementById('chatbotMinimize');
        const form = document.getElementById('chatbotForm');
        const input = document.getElementById('chatbotInput');
        const messages = document.getElementById('chatbotMessages');

        if (!widget || !panel || !toggle || !form || !input || !messages) {
          return;
        }

        const stateKey = 'apex_chatbot_open';

        const setOpen = (open) => {
          widget.classList.toggle('open', open);
          panel.setAttribute('aria-hidden', open ? 'false' : 'true');
          localStorage.setItem(stateKey, open ? '1' : '0');
          if (open) {
            setTimeout(() => input.focus(), 120);
          }
        };

        const appendMessage = (text, sender) => {
          const el = document.createElement('div');
          el.className = `chatbot-message ${sender}`;
          el.textContent = text;
          messages.appendChild(el);
          messages.scrollTop = messages.scrollHeight;
        };

        const sendMessage = async (content) => {
          appendMessage(content, 'user');
          input.value = '';
          input.focus();

          try {
            const response = await fetch("{{ route('chatbot.query') }}", {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json',
              },
              body: JSON.stringify({ message: content }),
            });

            if (!response.ok) {
              throw new Error('Network response was not ok');
            }

            const data = await response.json();
            appendMessage(data.reply || 'Sorry, I could not process that. Please try again.', 'bot');
          } catch (error) {
            appendMessage('I am having trouble connecting right now. Please try again in a moment.', 'bot');
          }
        };

        toggle.addEventListener('click', () => {
          const isOpen = widget.classList.contains('open');
          setOpen(!isOpen);
        });

        minimize?.addEventListener('click', () => setOpen(false));

        form.addEventListener('submit', (event) => {
          event.preventDefault();
          const content = input.value.trim();
          if (!content) {
            return;
          }
          sendMessage(content);
        });

        document.addEventListener('keydown', (event) => {
          if (event.key === 'Escape' && widget.classList.contains('open')) {
            setOpen(false);
          }
        });

        const shouldOpen = localStorage.getItem(stateKey) === '1';
        setOpen(shouldOpen);
      })();
    </script>

    <!-- Page-specific JS -->
    @yield('extra-js')
</body>
</html>