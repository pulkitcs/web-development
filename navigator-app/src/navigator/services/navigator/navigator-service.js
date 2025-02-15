import { fetchApiData } from '../api/api-service';
import API_SETTINGS from '../../config/api';

// Service to send routes to the API 
export const sendRoutes = (body) => {
	return fetchApiData(
		API_SETTINGS.MOCK_API['URL'], "POST", 
		API_SETTINGS.MOCK_API.NAVIGATOR_SUB_PATH,
		body
  );
}

// Service to receive routes from the API 
export const fetchRoutes = async (token) => {

	const res = await fetchApiData(
		API_SETTINGS.MOCK_API['URL'], "GET", 
		API_SETTINGS.MOCK_API.NAVIGATOR_SUB_PATH + '/' + token
  )

	// retrying if status is in progress
	if(res && res.status === API_SETTINGS.MOCK_API.MSG_IN_PROGRESS) {
		return fetchRoutes(token);
	}

	return res;
 }