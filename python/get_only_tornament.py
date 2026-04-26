from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import time
import json

def get_tournaments(category_id):
    url = f"https://www.sofascore.com/api/v1/category/{category_id}/unique-tournaments"

    options = webdriver.ChromeOptions()
    options.add_argument("--headless")  # roda sem abrir janela
    options.add_argument("--disable-blink-features=AutomationControlled")

    driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

    try:
        # 🔥 abre o site primeiro (gera cookies)
        driver.get("https://www.sofascore.com/")
        time.sleep(3)

        # 🔥 chama a API depois
        driver.get(url)
        time.sleep(2)

        data = json.loads(driver.find_element("tag name", "body").text)

        tournaments = []

        for group in data.get("groups", []):
            for t in group.get("uniqueTournaments", []):
                tournaments.append({
                    "id": t["id"],
                    "name": t["name"]
                })

        return tournaments

    except Exception as e:
        print("Erro:", e)
        return None

    finally:
        driver.quit()


tournaments = get_tournaments(1)

print("TOTAL:", len(tournaments))
print(tournaments[:10])