import React from "react";
import { shallow } from "enzyme";
import DisplayUsers  from "../DisplayUsers.js";

import SampleData from "../../data.json";

describe("Testing <DisplayUsers />", () => {
  let component;

  beforeEach(() => {
    component = shallow(<DisplayUsers data={SampleData}/>);
  });

  it("should render a HTML", () => {
    const element = component.find(".delete");
    expect(element.length).toBe(SampleData.length); // Length of the input array (SampleData)
  });

  it("should render correct HTML/Text from JSON", () => {
    const element = component.find(".name");
    const randomIndex = 1;
    const name = `${SampleData[randomIndex].first_name} ${SampleData[randomIndex].last_name}`;

    expect(element.at(randomIndex).text()).toBe(name);
  });
});