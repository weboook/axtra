<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #1a1a1a; font-weight: 700;">Email Templates</h1>
            <p class="text-muted mb-0">Preview all email templates used in the system</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge bg-success me-2">{{ count($emails) }} Templates</span>
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Refresh Templates">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075), 0 0 1px rgba(0, 0, 0, 0.05);">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="border: none;">
                    <thead>
                        <tr style="border-top: none;">
                            <th style="border: none; color: #6c757d; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 1rem 0.75rem;">Email Name</th>
                            <th style="border: none; color: #6c757d; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 1rem 0.75rem;">Category</th>
                            <th style="border: none; color: #6c757d; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 1rem 0.75rem;">Recipients</th>
                            <th style="border: none; color: #6c757d; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 1rem 0.75rem;">Trigger</th>
                            <th style="border: none; color: #6c757d; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 1rem 0.75rem;">Description</th>
                            <th style="border: none; color: #6c757d; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 1rem 0.75rem;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emails as $email)
                        <tr style="border-bottom: 1px solid #f8f9fa;">
                            <td style="border: none; padding: 1rem 0.75rem;">
                                <div class="d-flex align-items-center">
                                    <div class="me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px; background: {{ $email['category'] == 'Admin' ? 'rgba(220, 53, 69, 0.1)' : ($email['category'] == 'Booking' ? 'rgba(25, 135, 84, 0.1)' : ($email['category'] == 'Reminder' ? 'rgba(255, 193, 7, 0.1)' : 'rgba(13, 110, 253, 0.1)')) }}; border-radius: 10px;">
                                        <i class="fas fa-envelope" style="color: {{ $email['category'] == 'Admin' ? '#dc3545' : ($email['category'] == 'Booking' ? '#198754' : ($email['category'] == 'Reminder' ? '#ffc107' : '#0d6efd')) }};"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0" style="color: #1a1a1a; font-weight: 600;">{{ $email['name'] }}</h6>
                                        <small class="text-muted">Email Template</small>
                                    </div>
                                </div>
                            </td>
                            <td style="border: none; padding: 1rem 0.75rem;">
                                <span class="badge" style="background: {{ $email['category'] == 'Admin' ? '#dc3545' : ($email['category'] == 'Booking' ? '#198754' : ($email['category'] == 'Reminder' ? '#ffc107' : '#0d6efd')) }}; color: white; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 500;">
                                    {{ $email['category'] }}
                                </span>
                            </td>
                            <td style="border: none; padding: 1rem 0.75rem; color: #495057; font-weight: 500;">
                                {{ $email['recipients'] }}
                            </td>
                            <td style="border: none; padding: 1rem 0.75rem;">
                                <span class="text-muted" style="font-size: 0.875rem;">{{ $email['trigger'] }}</span>
                            </td>
                            <td style="border: none; padding: 1rem 0.75rem;">
                                <span class="text-muted" style="font-size: 0.875rem;">{{ $email['description'] }}</span>
                            </td>
                            <td style="border: none; padding: 1rem 0.75rem;">
                                <button type="button" 
                                        class="btn btn-outline-primary btn-sm d-flex align-items-center" 
                                        style="border-radius: 8px; padding: 8px 16px; font-weight: 500; border-color: #c02425; color: #c02425;"
                                        wire:click="previewEmail('{{ $email['id'] }}')"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#emailPreviewModal"
                                        onmouseover="this.style.background='#c02425'; this.style.color='white';"
                                        onmouseout="this.style.background='transparent'; this.style.color='#c02425';">
                                    <i class="fas fa-eye me-1"></i>
                                    Preview
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Email Preview Modal --}}
    <div class="modal fade" id="emailPreviewModal" tabindex="-1" aria-labelledby="emailPreviewModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);">
                <div class="modal-header" style="border-bottom: 1px solid #f8f9fa; padding: 1.5rem;">
                    <div class="d-flex align-items-center">
                        <div class="me-3 d-flex align-items-center justify-content-center" 
                             style="width: 48px; height: 48px; background: rgba(192, 36, 37, 0.1); border-radius: 12px;">
                            <i class="fas fa-envelope" style="color: #c02425; font-size: 1.25rem;"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="emailPreviewModalLabel" style="color: #1a1a1a; font-weight: 700;">
                                {{ $selectedEmail ? collect($emails)->firstWhere('id', $selectedEmail)['name'] ?? 'Email Preview' : 'Email Preview' }}
                            </h5>
                            <small class="text-muted">Template Preview</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    @if($emailContent)
                        <div class="email-preview-container" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem;">
                            <div class="email-preview-wrapper" style="max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); border: 1px solid rgba(0,0,0,0.05);">
                                {!! $emailContent !!}
                            </div>
                        </div>
                    @else
                        <div class="p-5 text-center">
                            <div class="mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px; background: rgba(192, 36, 37, 0.1); border-radius: 20px;">
                                    <i class="fas fa-envelope-open-text" style="color: #c02425; font-size: 2rem;"></i>
                                </div>
                            </div>
                            <h6 class="mb-2" style="color: #1a1a1a; font-weight: 600;">No Preview Available</h6>
                            <p class="text-muted mb-0">Select an email template to preview its content</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f8f9fa; padding: 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 20px; font-weight: 500;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript for Modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Modern Bootstrap 5 modal handling
            window.addEventListener('showEmailModal', function () {
                const modal = new bootstrap.Modal(document.getElementById('emailPreviewModal'));
                modal.show();
            });

            // Handle modal close to reset content
            document.getElementById('emailPreviewModal').addEventListener('hidden.bs.modal', function () {
                @this.set('selectedEmail', '');
                @this.set('emailContent', '');
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <style>
        .email-preview-container {
            max-height: 75vh;
            overflow-y: auto;
        }
        
        .email-preview-wrapper img {
            max-width: 100%;
            height: auto;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.15s ease;
        }
        
        .btn:hover {
            transform: translateY(-1px);
            transition: transform 0.15s ease;
        }

        /* Custom scrollbar for email preview */
        .email-preview-container::-webkit-scrollbar {
            width: 6px;
        }

        .email-preview-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .email-preview-container::-webkit-scrollbar-thumb {
            background: #c02425;
            border-radius: 3px;
        }

        .email-preview-container::-webkit-scrollbar-thumb:hover {
            background: #a01e1f;
        }
    </style>
</div>