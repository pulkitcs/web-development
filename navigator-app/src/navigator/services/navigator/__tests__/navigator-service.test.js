import * as ApiService from '../../api/api-service';
import { sendRoutes, fetchRoutes } from '../navigator-service';

describe('navigator-services', () => {
  
 // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/random#Getting_a_random_integer_between_two_values
  const getRandomInt = (min, max) => {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min)) + min;
  };
  
  test('sendRoutes() should receive sample token', async () => {
    const sampleToken = '3000';
    const requestBody = {};
    const apiService = jest.spyOn(ApiService, 'fetchApiData');

    apiService.mockImplementation(() =>
        Promise.resolve({ token: sampleToken })
    );

    const response = await sendRoutes(requestBody); // method being tested

    expect(response.token).toBe(sampleToken);
    apiService.mockRestore();
  });

  test('sendRoutes() return an error message in case of failed api request', async () => {
    const sampleMsg = 'Internal Server Error';
    const requestBody = {};
    const apiService = jest.spyOn(ApiService, 'fetchApiData');

    apiService.mockImplementation(() => Promise.reject(sampleMsg));

    await sendRoutes(requestBody).catch((e) => {
      expect(e).toBe(sampleMsg);
      apiService.mockRestore();
    });
  });

  test('fetchRoutes() should recieve JSON data ', async () => {
    const sampleData = {
      status: 'success',
      path: [
          ['22.372081', '114.107877'],
          ['22.326442', '114.167811'],
          ['22.284419', '114.159510']
      ],
      total_distance: 20000,
      total_time: 1800
    };

    const apiService = jest.spyOn(ApiService, 'fetchApiData');

    apiService.mockImplementation(() =>
        Promise.resolve(sampleData)
    );

    const response = await fetchRoutes(); // method being tested

    expect(response.status).toBe(sampleData.status);
    expect(response.path[0].length).toBe(sampleData.path[0].length);
    apiService.mockRestore();
  });

  test('fetchRoutes() return an error message in case of failed api request', async () => {
    const sampleMsg = 'Internal Server Error';
    const apiService = jest.spyOn(ApiService, 'fetchApiData');

    apiService.mockImplementation(() => Promise.reject(sampleMsg));

    await fetchRoutes().catch(e => {
      expect(e).toBe(sampleMsg);
      apiService.mockRestore();
    });
  });

  test('fetchRoutes() returns the status correctly and does recursion in case of "in progress" status', async () => {
    let statusMsg = { "status": "" };
    let timesCalled = 0;
    const apiService = jest.spyOn(ApiService, 'fetchApiData');

    // apiService invoked from fetchRoutes() method
    apiService.mockImplementation(() => {
      const dice = getRandomInt(0,3);
      timesCalled++;

      switch(dice) {
        case 0: {
          statusMsg.status = "success";
          break;
        }
        case 1: {
          statusMsg.status = "in progress";
          break;
        }
        case 2: {
          statusMsg.status = "failure";
          break;
        }
        default: {}
      }

      return Promise.resolve(statusMsg);
    });

    const response = await fetchRoutes();

    expect(response.status).toBe(statusMsg.status); // Should return the 'status'
    expect(apiService).toHaveBeenCalledTimes(timesCalled); // Should do recursion in case of 'in progress' status
    apiService.mockRestore();
  });
})