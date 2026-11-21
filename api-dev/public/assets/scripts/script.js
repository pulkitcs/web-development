const form = document.getElementById('form');
const table = document.getElementById('table');
const tbody = document.getElementById('tbody');

const handleFormValidation = async (e) => {
  const name = document.getElementById('name');
  const age = document.getElementById('age');
  const gender = document.getElementById('gender');
  const subscribe = document.getElementById('subscribe');

  const response = await window.fetch('/api/create', {
    method: 'POST',
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      name: name.value,
      age: age.value,
      gender: gender.value,
      opted_for_subscription: +(subscribe.checked),
    })
  });

  if (response.ok) {
      form.reset();
      fetchRegistrationDetails();
  }

  e.preventDefault();
  return false;
}

const fetchRegistrationDetails = async () => {
  const dataset = await window.fetch('/api/list').then(res => res.json());
  const dom = dataset.rows.reduce((agg, current) => {
    const {name, age, gender, opted_for_subscription } = current;

    agg += `<tr><td>${name}</td><td>${age}</td><td>${gender}</td><td>${opted_for_subscription}</td></tr>`;

    return agg;
  },  '');

  tbody.innerHTML = dom;
}

form.addEventListener('submit', handleFormValidation);
document.addEventListener('DOMContentLoaded', fetchRegistrationDetails)