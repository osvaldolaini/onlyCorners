from playwright.sync_api import sync_playwright
import json

EVENT_ID = 15235541

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)  # pode botar False pra ver abrindo
    context = browser.new_context()
    page = context.new_page()

    # 1. Abre o site (gera sessão real)
    page.goto("https://www.sofascore.com/")

    # 2. Espera carregar (importante)
    page.wait_for_timeout(3000)

    # 3. Faz request dentro do navegador
    data = page.evaluate(f"""
        async () => {{
            const res = await fetch("https://api.sofascore.com/api/v1/event/{EVENT_ID}");
            return await res.json();
        }}
    """)

    print(json.dumps(data, indent=2))

    browser.close()