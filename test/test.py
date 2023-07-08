import os
import time
from selenium import webdriver
from selenium.webdriver.chrome.options import Options


def main():

    SELENIUM_GRID_HOST = os.environ.get('SELENIUM_GRID_HOST', 'localhost')

    option = Options()

    option.add_argument('--headless')
    option.add_argument('--mute-audio')
    option.add_argument('--no-sandbox')
    option.add_argument('--disable-gpu')
    option.add_experimental_option('excludeSwitches', ['enable-logging'])

    driver = webdriver.Remote(
        command_executor="http://%s:4444" % SELENIUM_GRID_HOST,
        options=option
    )

    try:

        driver.maximize_window()

        driver.get('https://github.com/PONzu-0529/python-selenium')

        driver.save_screenshot("output_%s.png" % int(time.time()))

    except Exception as e:

        print('ERROR:', str(e))

    finally:

        driver.quit()


if (__name__ == '__main__'):

    main()
