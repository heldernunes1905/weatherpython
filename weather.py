import requests

#my api key
api_key = '05ce5a1ace570420c5617bdc27db297b'

#use inputs name of city and gets stored in object
city = input('Enter city name:')

#url with the city name and my api_key
url= f'http://api.openweathermap.org/data/2.5/weather?q={city}&appid={api_key}'


#get response code
response = requests.get(url)

#if 200 means everything is good which will get the necessary data
#print(response) - Response [200]
if response.status_code == 200:
    data = response.json()
    #print(data) -{'coord': {'lon': -0.1257, 'lat': 51.5085}, 'weather': [{'id': 804, 'main': 'Clouds', 'description': 'overcast clouds', 'icon': '04d'}], 'base': 'stations', 
    # 'main': {'temp': 293.2, 'feels_like': 292.88, 'temp_min': 291.79, 'temp_max': 294.21, 'pressure': 1007, 'humidity': 62}, 'visibility': 10000, 'wind': {'speed': 3.6, 'deg': 310}, 
    # 'clouds': {'all': 99}, 'dt': 1691087196, 'sys': {'type': 2, 'id': 2075535, 'country': 'GB', 'sunrise': 1691036795, 'sunset': 1691092005}, 
    # 'timezone': 3600, 'id': 2643743, 'name': 'London', 'cod': 200}

    temp = round(data['main']['temp'] - 273.15,2) #gets the current temperature at the city, gets returned in kelvin so it needs to be converted to celsius and then rounded for only 2 decimal cases
    desc = data['weather'][0]['description'] #description of current weather in city
    print(f'Temperature: {temp} C')
    print(f'Description: {desc}')
else:
    print('Error fetching weather data')