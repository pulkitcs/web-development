
// Method to extract data from any URL
export const fetchApiData = (URL, type, param = '', body = {}) => {
  const POST = 'POST';
  const config = { 'method': type }

  if (type === POST)
    config['body'] = JSON.stringify(body);

  return fetch(URL+param, config)
      .then(handleErrors)
      .then(res => { return res.json(); })
      .catch((e) => {
        return e; 
      });
}

// Method handles and created error
const handleErrors = (response) => {
  if (!response.ok) {
    return Promise.reject(response.statusText);
  }
  return response;
}