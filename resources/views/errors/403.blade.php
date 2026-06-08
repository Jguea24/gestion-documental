<x-app-layout>
    <style>
        .error-page {
            min-height: calc(100vh - 4rem);
            background: #eef2f7;
            color: #0f2747;
            padding: 32px 18px;
        }

        .error-shell {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            max-width: 1040px;
            margin: 0 auto;
            overflow: hidden;
            border: 1px solid #d9e2ef;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 20px 45px rgba(15, 39, 71, 0.1);
        }

        .error-panel {
            display: flex;
            min-height: 430px;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(145deg, #123b63 0%, #0f2747 62%, #0b1d35 100%);
            padding: 34px;
            color: #ffffff;
        }

        .error-code {
            display: inline-flex;
            width: fit-content;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            padding: 8px 13px;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.04em;
        }

        .error-badge {
            display: grid;
            height: 84px;
            width: 84px;
            place-items: center;
            border-radius: 24px;
            background: #ffffff;
            color: #1f4f82;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.2);
        }

        .error-badge svg {
            height: 42px;
            width: 42px;
        }

        .error-content {
            padding: 42px;
        }

        .error-eyebrow {
            margin-bottom: 12px;
            color: #1f4f82;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .error-title {
            margin: 0;
            color: #061a33;
            font-size: clamp(30px, 4vw, 44px);
            font-weight: 900;
            line-height: 1.05;
        }

        .error-text {
            margin-top: 18px;
            max-width: 620px;
            color: #365577;
            font-size: 16px;
            line-height: 1.7;
        }

        .error-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .error-button {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border-radius: 8px;
            padding: 0 17px;
            font-size: 13px;
            font-weight: 900;
            text-decoration: none;
        }

        .error-button-primary {
            border: 1px solid #1f4f82;
            background: #1f4f82;
            color: #ffffff;
        }

        .error-button-primary:hover {
            background: #173f68;
        }

        .error-button-secondary {
            border: 1px solid #b8c7da;
            background: #ffffff;
            color: #1f4f82;
        }

        .error-button-secondary:hover {
            background: #f5f8fc;
        }

        .error-help {
            margin-top: 28px;
            border-left: 4px solid #17a673;
            background: #f2fbf7;
            padding: 14px 16px;
            color: #24513f;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.55;
        }

        @media (max-width: 820px) {
            .error-shell {
                grid-template-columns: 1fr;
            }

            .error-panel {
                min-height: 210px;
                padding: 26px;
            }

            .error-content {
                padding: 28px;
            }
        }
    </style>

    <section class="error-page">
        <div class="error-shell">
            <aside class="error-panel" aria-hidden="true">
                <div class="error-code">
                    <span>403</span>
                    <span>{{ __('Restricted access') }}</span>
                </div>

                <div class="error-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="10" width="16" height="10" rx="2" />
                        <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                        <path d="M12 14v2.5" />
                    </svg>
                </div>
            </aside>

            <div class="error-content">
                <div class="error-eyebrow">{{ __('Permission required') }}</div>
                <h1 class="error-title">{{ __('You do not have access to this section') }}</h1>
                <p class="error-text">
                    {{ __('This folder, document, or module is protected. If you need to view it, ask an administrator to assign the corresponding permission.') }}
                </p>

                <div class="error-actions">
                    <a href="{{ route('explorer.index') }}" class="error-button error-button-primary">
                        <span>{{ __('Go to Explorer') }}</span>
                    </a>
                    <button type="button" onclick="history.back()" class="error-button error-button-secondary">
                        <span>{{ __('Go back') }}</span>
                    </button>
                </div>

                <div class="error-help">
                    {{ __('If you are a student, you will only see the folders that the administrator has enabled for your account.') }}
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
