import requests
import sys #only used if data is sent from php file
import json
import datetime


#my api key
api_key = '05ce5a1ace570420c5617bdc27db297b'

#use inputs name of city and gets stored in object

#city = input('Enter city name:') #using python input method

id_json = int(sys.argv[1]) #this is the variable coming from the php file



file = open('info.json')
datajson = json.load(file)
file.close



for dj in datajson:
    id_convert = list(dj.keys())
    if (id_convert[0] == '%d' % id_json):
        chosen_id = dj
        break

json_string = chosen_id['%d' % id_json]

parsed = json.loads(json_string)

time = datetime.datetime.now()
formatted_date = time.strftime("%Y-%m-%d %H:%M:%S")

city = parsed['name']



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

    parsed["temp"] = temp
    parsed["desc"] = desc
    parsed["date"] = formatted_date


    #print(f'Temperature: {temp} C ')
    #print(f'Description: {desc}')
else:
    print('Error fetching weather data')


updated_json = json.dumps(parsed)


# Update the specific element in the datajson list
for dj in datajson:
    id_convert = list(dj.keys())
    if int(id_convert[0]) == id_json:
        dj[str(id_json)] = updated_json
        break

print(datajson)

# Write the updated data back to the JSON file
with open('info.json', 'w') as file:
    json.dump(datajson, file, indent=4)