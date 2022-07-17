import pymysql
from selenium import webdriver
from bs4 import BeautifulSoup
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

def is_exist_by_css(driver : webdriver.Chrome,css_selector : str):
    try:
        driver.find_element(By.CSS_SELECTOR, css_selector)
    except NoSuchElementException:
        return False
    return True

#학년, 학기 선택.... 후에 드롭다운(이수구분, 학과)에 있는 option을 차례대로 선택
def control_driver(driver : webdriver.Chrome):
    year_select = Select(driver.find_element(By.CSS_SELECTOR, '#pYear'))
    year_select.select_by_value('2022') #년도 선택
    semester_select = Select(driver.find_element(By.CSS_SELECTOR, '#pTerm'))
    semester_select.select_by_visible_text('1학기') #학기 선택
    esoo_select = Select(driver.find_element(By.CSS_SELECTOR, '#pPobt'))
    time.sleep(1)
    #전선 전필 지교 지필 일선 교직 기교 심교 융필 융선
    esoo_select.select_by_visible_text('지교') #이수선택
    
    try:
        WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.CSS_SELECTOR, 'body > div.jconfirm.jconfirm-light.jconfirm-open > div.jconfirm-scrollpane > div > div > div > div > div > div > div > div.jconfirm-buttons > button.btn-main')))
        driver.find_element(By.CSS_SELECTOR,'body > div.jconfirm.jconfirm-light.jconfirm-open > div.jconfirm-scrollpane > div > div > div > div > div > div > div > div.jconfirm-buttons > button.btn-main').click()
    except:
        print('no pop up')
    
    if driver.find_element(By.CSS_SELECTOR, '#pSustMjCd').get_attribute('disabled') is None:
        department_list = driver.find_elements(By.CSS_SELECTOR, '#pSustMjCd > option')      
        department_select = Select(driver.find_element(By.CSS_SELECTOR, '#pSustMjCd'))
        for department in department_list:
            department_select.select_by_value(department.get_attribute('value'))
            driver.find_element(By.CSS_SELECTOR,'#btnSearch').click()
            #time.sleep(1)
            #crawling
    else:
        driver.find_element(By.CSS_SELECTOR,'#btnSearch').click()
        #time.sleep(1)
        #crawling
        
        
        
    # esoo_list = driver.find_elements(By.CSS_SELECTOR, '#pPobt > option')
    # esoo_select = Select(driver.find_element(By.CSS_SELECTOR, '#pPobt'))
    # for esoo in esoo_list:#이수구분 선택
    #     esoo_select.select_by_value(esoo.get_attribute('value'))
        

    #     #팝업창 제어
    #     try:
    #         WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.CSS_SELECTOR, 'body > div.jconfirm.jconfirm-light.jconfirm-open > div.jconfirm-scrollpane > div > div > div > div > div > div > div > div.jconfirm-buttons > button.btn-main')))
    #         driver.find_element(By.CSS_SELECTOR, 'body > div.jconfirm.jconfirm-light.jconfirm-open > div.jconfirm-scrollpane > div > div > div > div > div > div > div > div.jconfirm-buttons > button.btn-main').click()
    #     except:
    #         print('no popup')
    #     # 팝업창 제어하는 또다른 방법
    #     # time.sleep(1)
    #     # if is_exist_by_css(driver, 'body > div.jconfirm.jconfirm-light.jconfirm-open > div.jconfirm-scrollpane > div > div > div > div > div > div > div > div.jconfirm-buttons > button.btn-main'):
    #     #     driver.find_element(By.CSS_SELECTOR, 'body > div.jconfirm.jconfirm-light.jconfirm-open > div.jconfirm-scrollpane > div > div > div > div > div > div > div > div.jconfirm-buttons > button.btn-main').click()
        
    #     #test
    #     # if(esoo.get_attribute('value') != 'B04061'):
    #     #     continue
        
    #     if driver.find_element(By.CSS_SELECTOR, '#pSustMjCd').get_attribute('disabled') is None:
    #         department_list = driver.find_elements(By.CSS_SELECTOR, '#pSustMjCd > option')
    #         department_select = Select(driver.find_element(By.CSS_SELECTOR, '#pSustMjCd'))
    #         for department in department_list:
    #             department_select.select_by_value(department.get_attribute('value'))
    #             driver.find_element(By.CSS_SELECTOR,'#btnSearch').click()
    #             #crawling
    #             #time.sleep(1)
    #     else:
    #         driver.find_element(By.CSS_SELECTOR,'#btnSearch').click()
    #         #crawling
    #         time.sleep(3)

        
def main():
    driver = webdriver.Chrome(executable_path='C:/Users/junsub/study/2022 sum/KU_sugang/python_crawling/chromedriver.exe')
    driver.get('https://sugang.konkuk.ac.kr/sugang/jsp/search/searchMainOuter.jsp')

    control_driver(driver)
    
    
    
    
    driver.close()        
        
    
    
if __name__ == '__main__':
    main()
    
    print('ok')


#드롭다운 여러개 선택하는 방법 
    # year_select = Select(driver.find_element(By.CSS_SELECTOR, '#pYear'))
    # year_list = driver.find_elements(By.CSS_SELECTOR,'#pYear > option')
    # for year in year_list:
    #     year_select.select_by_value(year.get_attribute('value'))
    #     time.sleep(1)