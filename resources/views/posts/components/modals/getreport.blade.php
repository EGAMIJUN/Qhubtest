@php
    // フロントエンド確認用の仮データ
    $latestWarning = (object)[
        'message' => 'This is a warning message from admin.',
        'created_at' => now()
    ];
@endphp

@if ($latestWarning)
    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-warning">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="warningModalLabel">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>Warning Received
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ $latestWarning->message }}</p>
                    <p class="text-muted small">Sent at: {{ $latestWarning->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
