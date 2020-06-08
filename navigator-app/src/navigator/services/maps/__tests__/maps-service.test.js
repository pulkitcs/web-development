import * as GMap from '../maps-service';
import {gmap}  from '../maps-service';

describe('map-service', () => {
  test('gmap() returns a object', async () => {
    const mapObj = {
      draw: () => {}
    };
    const map = jest.spyOn(GMap, 'gmap');
    map.mockImplementation(() => {
      return Promise.resolve(mapObj);
    });
    const gMap = await gmap();
    expect(gMap).toBeTruthy();
  })
});