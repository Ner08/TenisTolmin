@php $uid = $panelId; @endphp

<div id="subpanel_content_{{ $uid }}" class="bg-gray-50 overflow-y-auto">
    @if ($type === 'bracket')
        @if ($isMobile)
            <x-sm-screen-leagues :brackets="collect([$bracket])" />
        @else
            @include('partials._league_bracket_stage', ['brackets' => collect([$bracket])])
        @endif
    @else
        @if ($isMobile)
            @include('partials._sm_league_group_stage', ['brackets' => collect([$bracket])])
        @else
            @include('partials._league_group_stage', ['brackets' => collect([$bracket])])
        @endif
    @endif
</div>

<div id="subpanel_chat_{{ $uid }}" class="bg-white" style="display:none">
    @include('partials._bracket_chat', ['bracket' => $bracket, 'uid' => $uid])
</div>
