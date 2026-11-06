<tr class="empty-row">
    <td colspan="{{ $colspan }}" class="text-center text-muted py-4 border-0">
        <div class="d-flex flex-column align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 6c0 1.1 4 2 9 2s9-.9 9-2-4-2-9-2-9 .9-9 2z" />
                <path d="M3 6v12c0 1.1 4 2 9 2" />
                <path d="M21 6v5" />
                <path d="M3 12c0 1.1 4 2 9 2" />
                <circle cx="18" cy="18" r="3" />
                <path d="m16.5 16.5 3 3" />
            </svg>

            <span>{{ $message }}</span>
        </div>
    </td>
</tr>
<style>
    .empty-row,
    .empty-row td {
        border: none !important;
        box-shadow: none !important;
    }
</style>
