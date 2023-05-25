import requests
from bs4 import BeautifulSoup
from urllib.parse import urljoin

# Login credentials
username = "ccs/00008/020"
password = "lloydtony2002."

# Create a session
session = requests.Session()

# Send a GET request to the login page to obtain necessary cookies
login_url = "https://student.maseno.ac.ke/"
response = session.get(login_url)
soup = BeautifulSoup(response.content, "html.parser")

# Print the soup for debugging
# print(soup)

# Extract necessary form fields for login
form = soup.find("form", {"id": "ctl01"})
if form is not None:
    action = form.get("action")
    method = form.get("method")
    inputs = form.find_all("input")
    data = {input_.get("name"): input_.get("value") for input_ in inputs}

    # Update form data with login credentials
    data["username"] = username
    data["password"] = password

    # Construct the absolute URL for the login action
    absolute_action = urljoin(login_url, action)

    # Send a POST request to login
    login_response = session.post(absolute_action, data=data)

    # Check if the login was successful
    if login_response.status_code == 200:
        # You are now logged in and can continue scraping the authenticated pages
        # Example: Access the dashboard page and scrape necessary data
        dashboard_url = "https://student.maseno.ac.ke/pages/Dashboard"
        dashboard_response = session.get(dashboard_url)
        dashboard_soup = BeautifulSoup(dashboard_response.content, "html.parser")
        # Extract and process the desired information from the dashboard page
        print(f"login successfull{dashboard_soup}")
    else:
        print("Login failed:", login_response.status_code)
        pass
else:
    print("Login form not found.")
