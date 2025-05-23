#!/usr/bin/env python

import random
from datetime import datetime, timedelta
import json


def generate_random_date():
    start_date = datetime(2023, 1, 1)
    end_date = datetime(2025, 12, 31)
    delta = end_date - start_date
    random_days = random.randint(0, delta.days)
    random_date = start_date + timedelta(days=random_days)
    return random_date.strftime('%Y-%m-%d')


categories = ["Disclosure", "Update", "Blog", "World", "Pricing"]

data = [{} for _ in range(25)]

for i in range(25):
    data[i] = {
        "date": generate_random_date(),
        "title": f"{i + 1} Item",
        "content": f"Here is a short description for a {{ category }} post on {{ date }}",
        "category": random.choice(categories)
    }

for item in data:
    item["content"] = item["content"].replace(
        "{{ category }}", item["category"].lower()).replace("{{ date }}", item["date"])

json_data = json.dumps(data, indent=4)

with open('news.json', 'w') as file:
    file.write(json_data)
