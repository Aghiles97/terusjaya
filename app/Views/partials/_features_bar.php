<?php
$isId = empty($activeLang) || $activeLang->short_form == 'id';
$items = [
    [
        'title' => $isId ? 'Produk Berkualitas' : 'Quality Products',
        'desc'  => $isId ? 'Pilihan terbaik untuk kamu' : 'Best choice for you',
        'icon'  => 'shield'
    ],
    [
        'title' => $isId ? 'Pengiriman Cepat' : 'Fast Shipping',
        'desc'  => $isId ? 'Ke seluruh Indonesia' : 'Across Indonesia',
        'icon'  => 'box'
    ],
    [
        'title' => $isId ? 'Layanan Customer Care' : 'Customer Care',
        'desc'  => $isId ? 'Siap membantu kamu' : 'Ready to help you',
        'icon'  => 'headset'
    ],
    [
        'title' => $isId ? 'Pembayaran Aman' : 'Secure Payment',
        'desc'  => $isId ? 'Banyak metode pembayaran' : 'Multiple payment methods',
        'icon'  => 'wallet'
    ]
];
$icons = [
    'shield'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>',
    'box'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 12v10"/><path d="m7.5 4.5 9 5.2"/><path d="M16.5 9.7V14"/></svg>',
    'headset' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12V9a8 8 0 0 1 16 0v3"/><rect x="2" y="12" width="4" height="6" rx="2"/><rect x="18" y="12" width="4" height="6" rx="2"/><path d="M6 17c0 2.2 1.8 4 4 4h2"/><circle cx="13" cy="21" r="1.2" fill="currentColor"/></svg>',
    'wallet'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="15" rx="3"/><line x1="2" y1="9" x2="22" y2="9"/><path d="M16 11h4a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v0a2 2 0 0 1 2-2z"/><circle cx="18.5" cy="14" r="0.8" fill="currentColor"/></svg>'
];
?>
<section class="section-features-bar" aria-label="Features">
    <div class="features-bar-container">
        <?php foreach ($items as $item): ?>
            <div class="features-bar-item">
                <div class="features-bar-icon">
                    <?= $icons[$item['icon']] ?? ''; ?>
                </div>
                <div class="features-bar-text">
                    <span class="features-bar-title"><?= esc($item['title']); ?></span>
                    <span class="features-bar-desc"><?= esc($item['desc']); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<style>
.section-features-bar {
    width: 100%;
    background-color: #fff;
    border-top: 1px solid #eaebed;
    border-bottom: 1px solid #eaebed;
    box-sizing: border-box;
}
.features-bar-container {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    margin: 0;
    padding: 0;
}
.features-bar-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    padding: 16px;
    border-inline-end: 1px solid #eaebed;
    box-sizing: border-box;
    min-width: 0;
}
.features-bar-item:nth-child(4n) {
    border-inline-end: none;
}
.features-bar-icon {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #111827;
}
.features-bar-icon svg {
    width: 34px;
    height: 34px;
    display: block;
}
.features-bar-text {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-width: 0;
    overflow: hidden;
}
.features-bar-title {
    font-size: 14px;
    font-weight: 600;
    line-height: 1.3;
    color: #111827;
    margin: 0;
    white-space: nowrap;
}
.features-bar-desc {
    font-size: 12px;
    line-height: 1.35;
    color: #64748b;
    margin-top: 2px;
    white-space: nowrap;
}
@media (max-width: 991.98px) {
    .features-bar-container {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .features-bar-item {
        padding: 12px 14px;
        gap: 10px;
        justify-content: flex-start;
        border-inline-end: 1px solid #eaebed;
    }
    .features-bar-item:nth-child(2n) {
        border-inline-end: none;
    }
    .features-bar-item:nth-child(1),
    .features-bar-item:nth-child(2) {
        border-bottom: 1px solid #eaebed;
    }
    .features-bar-icon svg {
        width: 28px;
        height: 28px;
    }
    .features-bar-title {
        font-size: 13px;
        line-height: 1.25;
        white-space: normal;
        word-break: break-word;
    }
    .features-bar-desc {
        font-size: 11px;
        line-height: 1.25;
        white-space: normal;
        word-break: break-word;
    }
}
@media (max-width: 480px) {
    .features-bar-item {
        padding: 10px 8px;
        gap: 7px;
    }
    .features-bar-icon svg {
        width: 24px;
        height: 24px;
    }
    .features-bar-title {
        font-size: 11.5px;
        line-height: 1.2;
        white-space: normal;
        word-break: break-word;
    }
    .features-bar-desc {
        font-size: 10px;
        line-height: 1.2;
        margin-top: 2px;
        white-space: normal;
        word-break: break-word;
    }
}
</style>
