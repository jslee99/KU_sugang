#중복이 없다고 가정 할시 사용할 코드 cur.executemany사용
import pymysql
from sqlite3 import Cursor
from selenium import webdriver
from bs4 import BeautifulSoup
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

lectures_buffer = []
year = '2022'
semester = '1학기'
esoo = '전선'

def open_db():
    conn = pymysql.connect(host='localhost', user='js1', password='jgtmapm3876', db='ku_sugang')
    cur = conn.cursor(pymysql.cursors.DictCursor)
    return conn, cur
    
def close_db(conn : pymysql.Connection, cur : Cursor):
    cur.close()
    conn.close()
    

def is_exist_by_css(driver : webdriver.Chrome,css_selector : str):
    try:
        driver.find_element(By.CSS_SELECTOR, css_selector)
    except NoSuchElementException:
        return False
    return True

def insert_database(conn : pymysql.Connection, cur : Cursor):
    global lectures_buffer
    insert_sql = """insert into ku_sugang_2022_1(haksu_id, category, id, title, credit, hours, how, _language, note, category_of_elective, grade, department, professor, summary)
                    values(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);"""
    cur.executemany(insert_sql, lectures_buffer)
    conn.commit()

def crawling_one_page(driver : webdriver.Chrome, conn : pymysql.Connection, cur : Cursor):#목록이 로딩된후 이 목록들에 대해 크롤링
    global lectures_buffer
    
    try:
        WebDriverWait(driver, 2).until(EC.presence_of_element_located((By.CSS_SELECTOR, '#gridLecture > tbody > tr.ui-widget-content')))
    except:
        print('no lecture')
        return
    
    html = driver.page_source
    soup = BeautifulSoup(html, 'html.parser')
    
    
    row_list = soup.select('#gridLecture > tbody > tr.ui-widget-content')
    #test
    # for row in row_list:
    #     print(row.select('td')[3].select_one('button').getText())
    # print('yes')
    
    for row in row_list:
        td_list = row.select('td')
        t = (td_list[1].string,#학수번호 0
             td_list[2].string,#이수구분 1
             td_list[3].select_one('button').string,#과목번호 2
             td_list[4].string,#교과목명 3
             td_list[5].string,#학점 4
             td_list[6].string,#시간 5 
             td_list[7].string,#강의종류 6
             td_list[8].string,#원어유형 7
             td_list[10].string,#비고 8
             td_list[11].string,#교양영역 9
             td_list[12].string,#개설학년 10
             td_list[13].string,#개설학과 11
             td_list[14].string.lstrip(),#교강사 12
             td_list[15].string.lstrip()#강의요시 13
             )       
        lectures_buffer.append(t)
    #빈칸에서 \xa0 이 crawling되고 이를 mysql에 insert하는 경우에 그냥 빈 문자열로 insert된다(?)

#학년, 학기 선택.... 후에 드롭다운(이수구분, 학과)에 있는 option을 차례대로 선택
def control_driver(driver : webdriver.Chrome, conn : pymysql.Connection, cur : Cursor):
    global year
    global semester
    global esoo
    
    year_select = Select(driver.find_element(By.CSS_SELECTOR, '#pYear'))
    year_select.select_by_value(year) #년도 선택
    semester_select = Select(driver.find_element(By.CSS_SELECTOR, '#pTerm'))
    semester_select.select_by_visible_text(semester) #학기 선택
    esoo_select = Select(driver.find_element(By.CSS_SELECTOR, '#pPobt'))
    #time.sleep(1)
    #전선 전필 지교 지필 일선 교직 기교 심교 융필 융선
    esoo_select.select_by_visible_text(esoo) #이수선택
    
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
            crawling_one_page(driver, conn , cur)
    else:
        driver.find_element(By.CSS_SELECTOR,'#btnSearch').click()
        #time.sleep(1)
        crawling_one_page(driver, conn, cur)
        
    insert_database(conn, cur)
    
        
        
    
    # 이수구분 자동화 코드, 팝업창이 불규칙적으로 떠서 실패    
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
    url = 'https://sugang.konkuk.ac.kr/sugang/jsp/search/searchMainOuter.jsp'
    driver = webdriver.Chrome(executable_path='C:/Users/junsub/study/2022 sum/KU_sugang/python_crawling/chromedriver.exe')
    driver.get(url)

    conn, cur = open_db()

    control_driver(driver, conn, cur)
    
    close_db(conn, cur)
    
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