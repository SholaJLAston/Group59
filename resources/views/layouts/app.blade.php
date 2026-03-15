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

        <button type="button" class="chatbot-resize-handle n" data-resize="n" aria-label="Resize chat from top"></button>
        <button type="button" class="chatbot-resize-handle s" data-resize="s" aria-label="Resize chat from bottom"></button>
        <button type="button" class="chatbot-resize-handle e" data-resize="e" aria-label="Resize chat from right"></button>
        <button type="button" class="chatbot-resize-handle w" data-resize="w" aria-label="Resize chat from left"></button>
        <button type="button" class="chatbot-resize-handle ne" data-resize="ne" aria-label="Resize chat from top right"></button>
        <button type="button" class="chatbot-resize-handle nw" data-resize="nw" aria-label="Resize chat from top left"></button>
        <button type="button" class="chatbot-resize-handle se" data-resize="se" aria-label="Resize chat from bottom right"></button>
        <button type="button" class="chatbot-resize-handle sw" data-resize="sw" aria-label="Resize chat from bottom left"></button>
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
        const header = panel.querySelector('.chatbot-header');
        const resizeHandles = panel.querySelectorAll('.chatbot-resize-handle');
        const form = document.getElementById('chatbotForm');
        const input = document.getElementById('chatbotInput');
        const messages = document.getElementById('chatbotMessages');

        if (!widget || !panel || !toggle || !form || !input || !messages || !header || !resizeHandles.length) {
          return;
        }

        const stateKey = 'apex_chatbot_open';
        const sizeKey = 'apex_chatbot_size';
        const positionKey = 'apex_chatbot_position';
        const defaultWidth = 370;
        const defaultHeight = 520;
        const minWidth = 300;
        const minHeight = 360;

        let isDragging = false;
        let isResizing = false;
        let dragOffsetX = 0;
        let dragOffsetY = 0;
        let resizeStartX = 0;
        let resizeStartY = 0;
        let resizeStartLeft = 0;
        let resizeStartTop = 0;
        let resizeStartWidth = 0;
        let resizeStartHeight = 0;
        let resizeDirection = 'se';

        const clamp = (value, min, max) => Math.min(Math.max(value, min), max);

        const getViewportBounds = () => ({
          width: window.innerWidth,
          height: window.innerHeight,
          margin: 8,
        });

        const saveSize = () => {
          localStorage.setItem(sizeKey, JSON.stringify({
            width: panel.offsetWidth,
            height: panel.offsetHeight,
          }));
        };

        const savePosition = () => {
          localStorage.setItem(positionKey, JSON.stringify({
            left: parseFloat(panel.style.left || '0'),
            top: parseFloat(panel.style.top || '0'),
          }));
        };

        const applyPanelGeometry = () => {
          panel.style.position = 'fixed';

          const bounds = getViewportBounds();
          const savedSize = JSON.parse(localStorage.getItem(sizeKey) || 'null');
          const savedPos = JSON.parse(localStorage.getItem(positionKey) || 'null');

          const width = clamp(
            savedSize?.width ?? defaultWidth,
            minWidth,
            Math.max(minWidth, bounds.width - bounds.margin * 2)
          );
          const height = clamp(
            savedSize?.height ?? defaultHeight,
            minHeight,
            Math.max(minHeight, bounds.height - bounds.margin * 2)
          );

          panel.style.width = `${width}px`;
          panel.style.height = `${height}px`;
          panel.style.maxWidth = 'none';

          const defaultLeft = bounds.width - width - 24;
          const defaultTop = bounds.height - height - 96;

          const left = clamp(
            savedPos?.left ?? defaultLeft,
            bounds.margin,
            bounds.width - width - bounds.margin
          );

          const top = clamp(
            savedPos?.top ?? defaultTop,
            bounds.margin,
            bounds.height - height - bounds.margin
          );

          panel.style.left = `${left}px`;
          panel.style.top = `${top}px`;
          panel.style.right = 'auto';
          panel.style.bottom = 'auto';
        };

        const normalizePanelIntoViewport = () => {
          const bounds = getViewportBounds();
          const width = clamp(panel.offsetWidth, minWidth, Math.max(minWidth, bounds.width - bounds.margin * 2));
          const height = clamp(panel.offsetHeight, minHeight, Math.max(minHeight, bounds.height - bounds.margin * 2));

          let left = parseFloat(panel.style.left || '0');
          let top = parseFloat(panel.style.top || '0');

          left = clamp(left, bounds.margin, bounds.width - width - bounds.margin);
          top = clamp(top, bounds.margin, bounds.height - height - bounds.margin);

          panel.style.width = `${width}px`;
          panel.style.height = `${height}px`;
          panel.style.left = `${left}px`;
          panel.style.top = `${top}px`;

          saveSize();
          savePosition();
        };

        const setOpen = (open) => {
          widget.classList.toggle('open', open);
          panel.setAttribute('aria-hidden', open ? 'false' : 'true');
          localStorage.setItem(stateKey, open ? '1' : '0');
          if (open) {
            normalizePanelIntoViewport();
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

        header.addEventListener('pointerdown', (event) => {
          if (event.target.closest('button')) {
            return;
          }

          isDragging = true;
          panel.classList.add('dragging');

          const rect = panel.getBoundingClientRect();
          dragOffsetX = event.clientX - rect.left;
          dragOffsetY = event.clientY - rect.top;

          try {
            header.setPointerCapture(event.pointerId);
          } catch (_) {}
        });

        header.addEventListener('pointermove', (event) => {
          if (!isDragging) {
            return;
          }

          const bounds = getViewportBounds();
          const width = panel.offsetWidth;
          const height = panel.offsetHeight;

          const left = clamp(event.clientX - dragOffsetX, bounds.margin, bounds.width - width - bounds.margin);
          const top = clamp(event.clientY - dragOffsetY, bounds.margin, bounds.height - height - bounds.margin);

          panel.style.left = `${left}px`;
          panel.style.top = `${top}px`;
        });

        const stopDragging = (event) => {
          if (!isDragging) {
            return;
          }

          isDragging = false;
          panel.classList.remove('dragging');
          savePosition();

          try {
            header.releasePointerCapture(event.pointerId);
          } catch (_) {}
        };

        header.addEventListener('pointerup', stopDragging);
        header.addEventListener('pointercancel', stopDragging);

        const startResizing = (event) => {
          const handle = event.currentTarget;
          resizeDirection = handle.dataset.resize || 'se';
          isResizing = true;
          panel.classList.add('resizing');

          resizeStartX = event.clientX;
          resizeStartY = event.clientY;
          resizeStartLeft = parseFloat(panel.style.left || '0');
          resizeStartTop = parseFloat(panel.style.top || '0');
          resizeStartWidth = panel.offsetWidth;
          resizeStartHeight = panel.offsetHeight;

          try {
            handle.setPointerCapture(event.pointerId);
          } catch (_) {}

          event.preventDefault();
        };

        const onResizing = (event) => {
          if (!isResizing) {
            return;
          }

          const bounds = getViewportBounds();
          const dx = event.clientX - resizeStartX;
          const dy = event.clientY - resizeStartY;

          let nextLeft = resizeStartLeft;
          let nextTop = resizeStartTop;
          let nextWidth = resizeStartWidth;
          let nextHeight = resizeStartHeight;

          if (resizeDirection.includes('e')) {
            const maxWidth = bounds.width - nextLeft - bounds.margin;
            nextWidth = clamp(resizeStartWidth + dx, minWidth, Math.max(minWidth, maxWidth));
          }

          if (resizeDirection.includes('s')) {
            const maxHeight = bounds.height - nextTop - bounds.margin;
            nextHeight = clamp(resizeStartHeight + dy, minHeight, Math.max(minHeight, maxHeight));
          }

          if (resizeDirection.includes('w')) {
            const maxLeft = resizeStartLeft + resizeStartWidth - minWidth;
            nextLeft = clamp(resizeStartLeft + dx, bounds.margin, maxLeft);
            const maxWidth = bounds.width - nextLeft - bounds.margin;
            nextWidth = clamp(resizeStartWidth - (nextLeft - resizeStartLeft), minWidth, Math.max(minWidth, maxWidth));
          }

          if (resizeDirection.includes('n')) {
            const maxTop = resizeStartTop + resizeStartHeight - minHeight;
            nextTop = clamp(resizeStartTop + dy, bounds.margin, maxTop);
            const maxHeight = bounds.height - nextTop - bounds.margin;
            nextHeight = clamp(resizeStartHeight - (nextTop - resizeStartTop), minHeight, Math.max(minHeight, maxHeight));
          }

          panel.style.left = `${nextLeft}px`;
          panel.style.top = `${nextTop}px`;
          panel.style.width = `${nextWidth}px`;
          panel.style.height = `${nextHeight}px`;
        };

        const stopResizing = (event) => {
          if (!isResizing) {
            return;
          }

          isResizing = false;
          panel.classList.remove('resizing');
          saveSize();
          savePosition();

          try {
            const handle = event.currentTarget;
            handle.releasePointerCapture(event.pointerId);
          } catch (_) {}
        };

        resizeHandles.forEach((handle) => {
          handle.addEventListener('pointerdown', startResizing);
          handle.addEventListener('pointermove', onResizing);
          handle.addEventListener('pointerup', stopResizing);
          handle.addEventListener('pointercancel', stopResizing);
        });

        window.addEventListener('resize', normalizePanelIntoViewport);

        applyPanelGeometry();
        const shouldOpen = localStorage.getItem(stateKey) === '1';
        setOpen(shouldOpen);
      })();
    </script>

    <!-- Page-specific JS -->
    @yield('extra-js')
</body>
</html>