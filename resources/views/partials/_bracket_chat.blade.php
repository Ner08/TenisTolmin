@php
    $messages     = $bracket->bracketComments->sortBy('created_at');
    $authId       = auth()->id();
    $authInitials = auth()->check()
        ? collect(explode(' ', auth()->user()->name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('')
        : '';
@endphp

<style>
.force-show-time .msg-time { opacity: 1 !important; }
</style>

<div class="flex flex-col h-full">

    {{-- Messages area --}}
    <div class="flex-1 min-h-0 overflow-y-auto" id="chatScroll_{{ $bracket->id }}">
    <div class="max-w-screen-2xl mx-auto px-1 sm:px-4 py-3 space-y-1" id="chat_{{ $bracket->id }}">

        @forelse ($messages as $i => $msg)
            @php
                $isOwn     = $authId && $msg->user_id === $authId;
                $prevMsg   = $i > 0 ? $messages->values()[$i - 1] : null;
                $nextMsg   = isset($messages->values()[$i + 1]) ? $messages->values()[$i + 1] : null;
                $isFirst   = !$prevMsg || $prevMsg->user_id !== $msg->user_id;
                $isLast    = !$nextMsg || $nextMsg->user_id !== $msg->user_id;
                $showTime  = !$nextMsg || $msg->created_at->diffInSeconds($nextMsg->created_at) >= 300;
                $initials  = collect(explode(' ', $msg->user->name ?? '?'))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
                $timeLabel = $msg->created_at->format('d.m. H:i');
            @endphp

            <div class="{{ $isFirst ? 'mt-3' : 'mt-0.5' }} flex items-end gap-2"
                 data-user="{{ $msg->user_id }}"
                 data-ts="{{ $msg->created_at->timestamp }}"
                 data-msg-id="{{ $msg->id }}"
                 data-sender="{{ $msg->user->name ?? 'Neznan' }}"
                 @auth
                     @if (auth()->id() === $msg->user_id || auth()->user()->is_admin)data-delete-url="{{ route('brackets.chat.destroy', $msg->id) }}"@endif
                     @if (auth()->id() === $msg->user_id)data-update-url="{{ route('brackets.chat.update', $msg->id) }}"@endif
                 @endauth>

                @if (!$isOwn)
                    <div class="ml-1 w-6 h-6 sm:w-7 sm:h-7 flex-shrink-0">
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-xs font-bold text-gray-600">{{ $initials }}</span>
                        </div>
                    </div>
                @endif

                <div class="{{ $isOwn ? 'items-end ml-auto' : 'items-start' }} flex flex-col max-w-[90%] sm:max-w-[72%]">
                    @if ($isFirst)
                        <p class="text-xs font-semibold text-gray-500 mb-1 px-1">{{ $msg->user->name ?? 'Neznan' }}</p>
                    @endif
                    <div @class([
                        'chat-bubble px-3.5 py-2 text-sm leading-relaxed whitespace-pre-line break-words select-none',
                        'bg-amber-500 text-gray-900 rounded-2xl rounded-br-md' => $isOwn,
                        'bg-gray-100 text-gray-800 rounded-2xl rounded-bl-md' => !$isOwn,
                    ])>{{ $msg->content }}</div>
                    <div class="msg-meta flex items-center gap-2 px-1 mt-0.5">
                        @if ($msg->is_edited)
                            <span class="edited-label text-xs text-gray-400 italic">urejeno</span>
                        @endif
                        <span class="msg-time text-xs text-gray-400">{{ $msg->created_at->format('d.m. H:i') }}</span>
                    </div>
                </div>

                @if ($isOwn)
                    <div class="mr-1 w-6 h-6 sm:w-7 sm:h-7 flex-shrink-0">
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-amber-500/20 flex items-center justify-center">
                            <span class="text-xs font-bold text-amber-600">{{ $authInitials }}</span>
                        </div>
                    </div>
                @endif

            </div>
        @empty
            <div class="empty-state flex flex-col items-center justify-center h-full text-center py-12">
                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Še ni sporočil</p>
                <p class="text-xs text-gray-400 mt-1">Dogovorite se kdaj boste igrali</p>
            </div>
        @endforelse
    </div>
    </div>

    {{-- Input area — always at bottom --}}
    <div class="flex-shrink-0 border-t border-gray-100 bg-white">
    <div class="max-w-screen-2xl mx-auto px-4 py-3">
        @auth
            @if (auth()->user()->isApproved())
                <form id="chatForm{{ $bracket->id }}" method="POST"
                      action="{{ route('brackets.chat.store', $bracket->id) }}"
                      class="flex gap-2 items-end">
                    @csrf
                    <textarea name="content" id="chatInput{{ $bracket->id }}" required maxlength="500" rows="1"
                        placeholder="Sporočilo..."
                        class="flex-1 bg-gray-100 rounded-2xl px-4 py-2.5 text-sm resize-none overflow-hidden leading-5 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition-colors border border-transparent focus:border-amber-300"></textarea>
                    <button type="submit"
                        class="w-9 h-9 bg-amber-500 hover:bg-amber-400 text-gray-900 rounded-full flex items-center justify-center flex-shrink-0 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
            @else
                <p class="text-xs text-gray-400 text-center py-1">Vaša registracija še čaka na odobritev.</p>
            @endif
        @else
            <div class="flex items-center justify-between gap-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5">
                <p class="text-xs text-gray-500">Prijavite se za klepet v skupini.</p>
                <a href="{{ route('login_view') }}"
                   class="flex-shrink-0 text-xs font-semibold text-gray-900 bg-amber-500 hover:bg-amber-400 transition-colors px-3 py-1.5 rounded-lg">
                    Prijava
                </a>
            </div>
        @endauth
    </div>
    </div>

    {{-- Long-press context menu (bottom sheet) --}}
    <div id="ctxOverlay_{{ $bracket->id }}" class="hidden fixed inset-0 z-[60] bg-black/20" style="touch-action:none"></div>
    <div id="ctxMenu_{{ $bracket->id }}" class="hidden fixed bottom-0 left-0 right-0 z-[70] bg-white rounded-t-2xl shadow-2xl" style="padding-bottom: env(safe-area-inset-bottom, 0px)">
        <div class="w-8 h-1 bg-gray-200 rounded-full mx-auto mt-3 mb-3"></div>
        <button id="ctxEdit_{{ $bracket->id }}"
            class="hidden w-full flex items-center gap-4 px-5 py-4 text-sm font-medium text-gray-800 hover:bg-gray-50 active:bg-gray-100 border-t border-gray-100">
            <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Uredi sporočilo
        </button>
        <button id="ctxDelete_{{ $bracket->id }}"
            class="hidden w-full flex items-center gap-4 px-5 py-4 text-sm font-medium text-red-500 hover:bg-red-50 active:bg-red-100 border-t border-gray-100">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Izbriši sporočilo
        </button>
        <div class="h-4"></div>
    </div>
</div>

<script>
(function() {
    var chatEl    = document.getElementById('chat_{{ $bracket->id }}');
    var scrollEl  = document.getElementById('chatScroll_{{ $bracket->id }}');
    var textarea  = document.getElementById('chatInput{{ $bracket->id }}');
    var form      = document.getElementById('chatForm{{ $bracket->id }}');
    var pollUrl   = '{{ route('brackets.chat.poll', $bracket->id) }}';
    var lastId    = {{ $messages->last()?->id ?? 0 }};
    var isVisible = false;
    var csrfToken = '{{ csrf_token() }}';

    // Context menu elements
    var ctxOverlay  = document.getElementById('ctxOverlay_{{ $bracket->id }}');
    var ctxMenu     = document.getElementById('ctxMenu_{{ $bracket->id }}');
    var ctxEditBtn  = document.getElementById('ctxEdit_{{ $bracket->id }}');
    var ctxDeleteBtn= document.getElementById('ctxDelete_{{ $bracket->id }}');
    var ctxTarget   = null; // currently held message row

    function showCtxMenu(row) {
        var canEdit   = !!row.dataset.updateUrl;
        var canDelete = !!row.dataset.deleteUrl;
        if (!canEdit && !canDelete) return;

        ctxTarget = row;
        ctxEditBtn.style.display   = canEdit   ? 'flex' : 'none';
        ctxDeleteBtn.style.display = canDelete ? 'flex' : 'none';
        ctxOverlay.classList.remove('hidden');
        ctxMenu.classList.remove('hidden');
    }

    function hideCtxMenu() {
        ctxOverlay.classList.add('hidden');
        ctxMenu.classList.add('hidden');
        ctxTarget = null;
    }

    ctxOverlay.addEventListener('click', hideCtxMenu);

    ctxEditBtn.addEventListener('click', function() {
        if (!ctxTarget) return;
        var row       = ctxTarget;
        var updateUrl = row.dataset.updateUrl;
        var bubble    = row.querySelector('.chat-bubble');
        if (!bubble) return;
        hideCtxMenu();

        var original = bubble.textContent;
        var isOwn    = row.querySelector('.ml-auto') !== null;

        // Replace bubble with inline editor
        var editor = document.createElement('div');
        editor.className = 'flex flex-col gap-1.5 max-w-[90%] sm:max-w-[72%] ' + (isOwn ? 'ml-auto items-end' : 'items-start');
        editor.innerHTML =
            '<textarea class="text-sm px-3.5 py-2 rounded-2xl border-2 border-amber-400 focus:outline-none resize-none w-full ' +
                (isOwn ? 'bg-amber-100 text-gray-900 rounded-br-md' : 'bg-white text-gray-800 rounded-bl-md') +
            '" rows="2">' + escHtml(original) + '</textarea>' +
            '<div class="flex gap-2">' +
                '<button class="ctx-cancel text-xs text-gray-500 hover:text-gray-800 px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200">Prekliči</button>' +
                '<button class="ctx-save text-xs font-semibold text-gray-900 bg-amber-400 hover:bg-amber-500 px-3 py-1.5 rounded-lg">Shrani</button>' +
            '</div>';

        bubble.parentNode.insertBefore(editor, bubble);
        bubble.style.display = 'none';
        editor.querySelector('textarea').focus();

        editor.querySelector('.ctx-cancel').addEventListener('click', function() {
            bubble.style.display = '';
            editor.remove();
        });

        editor.querySelector('.ctx-save').addEventListener('click', function() {
            var newContent = editor.querySelector('textarea').value.trim();
            if (!newContent) return;
            fetch(updateUrl, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ content: newContent })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                bubble.textContent = data.content;
                bubble.style.display = '';
                editor.remove();
                // Show "urejeno" label if not already present
                var meta = row.querySelector('.msg-meta');
                if (meta && !meta.querySelector('.edited-label')) {
                    var label = document.createElement('span');
                    label.className = 'edited-label text-xs text-gray-400 italic';
                    label.textContent = 'urejeno';
                    meta.prepend(label);
                }
            });
        });
    });

    ctxDeleteBtn.addEventListener('click', function() {
        if (!ctxTarget) return;
        var row       = ctxTarget;
        var deleteUrl = row.dataset.deleteUrl;
        hideCtxMenu();
        if (!confirm('Izbrisati to sporočilo?')) return;
        fetch(deleteUrl, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
        })
        .then(function(r) {
            if (!r.ok) return;
            var bubble = row.querySelector('.chat-bubble');
            if (bubble) {
                bubble.className = 'flex items-center gap-2';
                var ts = parseInt(row.dataset.ts);
                var d  = ts ? new Date(ts * 1000) : null;
                var timeStr = d ? (String(d.getDate()).padStart(2,'0') + '.' + String(d.getMonth()+1).padStart(2,'0') + '. ' + String(d.getHours()).padStart(2,'0') + ':' + String(d.getMinutes()).padStart(2,'0')) : '';
                bubble.innerHTML =
                    '<span class="text-xs font-semibold text-gray-400">' + escHtml(row.dataset.sender || '') + '</span>' +
                    '<span class="text-gray-300">·</span>' +
                    (timeStr ? '<span class="text-xs text-gray-400">' + timeStr + '</span><span class="text-gray-300">·</span>' : '') +
                    '<span class="text-xs text-gray-400 italic">Sporočilo zbrisano.</span>';
            }
            var meta = row.querySelector('.msg-meta');
            if (meta) meta.remove();
            delete row.dataset.deleteUrl;
            delete row.dataset.updateUrl;
        });
    });

    function addLongPress(el) {
        var timer;
        el.addEventListener('touchstart', function(e) {
            timer = setTimeout(function() { showCtxMenu(el); }, 500);
        }, { passive: true });
        el.addEventListener('touchend',  function() { clearTimeout(timer); });
        el.addEventListener('touchmove', function() { clearTimeout(timer); });
        // Desktop: right-click
        el.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            showCtxMenu(el);
        });
    }

    chatEl.querySelectorAll('[data-msg-id]').forEach(addLongPress);

    if (!textarea || !form) return;

    // Auto-grow textarea
    function autoGrow() {
        textarea.style.height = 'auto';
        textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
    }
    textarea.addEventListener('input', autoGrow);

    // Enter to send
    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (textarea.value.trim()) sendMessage();
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (textarea.value.trim()) sendMessage();
    });

    function sendMessage() {
        var content = textarea.value;
        var token   = form.querySelector('[name="_token"]').value;
        textarea.value = '';
        textarea.style.height = 'auto';

        var empty = chatEl.querySelector('.empty-state');
        if (empty) empty.remove();

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify({ content: content })
        })
        .then(function(r) { return r.json(); })
        .then(function(msg) {
            appendMessage(msg, true);
            lastId = msg.id;
            scrollToBottom();
        })
        .catch(function() {
            textarea.value = content;
        });
    }

    function escHtml(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
                  .replace(/"/g,'&quot;').replace(/\n/g,'<br>');
    }

    function poll() {
        if (!isVisible) return;
        fetch(pollUrl + '?after=' + lastId, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': form ? form.querySelector('[name="_token"]').value : '' }
        })
        .then(function(r) { return r.json(); })
        .then(function(msgs) {
            msgs.forEach(function(msg) {
                if (msg.id > lastId) {
                    appendMessage(msg, msg.is_own);
                    lastId = msg.id;
                }
            });
            if (msgs.length) scrollToBottom();
        })
        .catch(function() {});
    }

    var subpanel = document.getElementById('subpanel_chat_{{ $uid ?? '' }}');
    var observer = new MutationObserver(function() {
        isVisible = subpanel && subpanel.style.display !== 'none';
    });
    if (subpanel) observer.observe(subpanel, { attributes: true, attributeFilter: ['style'] });
    isVisible = subpanel && subpanel.style.display !== 'none';

    setInterval(poll, 10000);

    function appendMessage(msg, isOwn) {
        var empty = chatEl.querySelector('.empty-state');
        if (empty) empty.remove();

        var lastEl   = chatEl.lastElementChild;
        var sameUser = lastEl && lastEl.dataset.user == msg.user_id;

        var div = document.createElement('div');
        div.className = (sameUser ? 'mt-0.5' : 'mt-3') + ' flex items-end gap-2';
        div.dataset.user    = msg.user_id;
        div.dataset.ts      = msg.ts;
        div.dataset.msgId   = msg.id;
        if (msg.delete_url) div.dataset.deleteUrl = msg.delete_url;
        if (msg.update_url) div.dataset.updateUrl = msg.update_url;

        if (isOwn) {
            div.innerHTML =
                '<div class="items-end ml-auto flex flex-col max-w-[90%] sm:max-w-[72%]">' +
                    (!sameUser ? '<p class="text-xs font-semibold text-gray-500 mb-1 px-1">' + escHtml(msg.user_name) + '</p>' : '') +
                    '<div class="chat-bubble px-3.5 py-2 text-sm leading-relaxed break-words bg-amber-500 text-gray-900 rounded-2xl rounded-br-md select-none">' + escHtml(msg.content) + '</div>' +
                    '<div class="msg-meta flex items-center gap-2 px-1 mt-0.5"><span class="msg-time text-xs text-gray-400">' + escHtml(msg.created_at) + '</span></div>' +
                '</div>' +
                '<div class="w-7 flex-shrink-0"></div>';
        } else {
            var initials = msg.initials || (msg.user_name || '?').split(' ').map(function(w){ return (w[0]||'').toUpperCase(); }).slice(0,2).join('');
            div.innerHTML =
                '<div class="w-7 h-7 flex-shrink-0">' +
                    (!sameUser ? '<div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center"><span class="text-xs font-bold text-gray-600">' + escHtml(initials) + '</span></div>' : '') +
                '</div>' +
                '<div class="items-start flex flex-col max-w-[90%] sm:max-w-[72%]">' +
                    (!sameUser ? '<p class="text-xs font-semibold text-gray-500 mb-1 px-1">' + escHtml(msg.user_name) + '</p>' : '') +
                    '<div class="chat-bubble px-3.5 py-2 text-sm leading-relaxed break-words bg-gray-100 text-gray-800 rounded-2xl rounded-bl-md select-none">' + escHtml(msg.content) + '</div>' +
                    '<div class="msg-meta flex items-center gap-2 px-1 mt-0.5"><span class="msg-time text-xs text-gray-400">' + escHtml(msg.created_at) + '</span></div>' +
                '</div>';
        }

        addLongPress(div);
        chatEl.appendChild(div);
    }
})();
</script>
