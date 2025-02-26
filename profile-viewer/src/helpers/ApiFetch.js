const ApiFetch = (URL, method) => {
  return fetch(URL, {
    method: method,
    headers: {
      "Content-Type": "application/json; charset=utf-8",
    },
  })
    .then((res) => res.json())
    .catch((error) => {
      const err = {
        error,
      };
      // console.error(error);
      return err;
    });
};

export default ApiFetch;
