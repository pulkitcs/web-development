import React from "react";
import { shallow } from "enzyme";
import PearsonUsers  from "../PearsonUsers.js";
import ErrorMsg from "../../../helpers/ErrorMsg.js";
import SampleData from "../data.json";

describe("Testing <PearsonUsers />", () => {
  let component;

  beforeEach(() => {
    component = shallow(<PearsonUsers />);
  });

  it("renders a h1", () => {
    const h1 = component.find("h1");
    expect(h1.text()).toEqual("Pearson User Management");
  });

  it("Should remove Duplicates", () => {
    const newArray = component.instance().removeDuplicate(SampleData);
    expect(newArray.length).toBe(3);
  });

  it("Should Delete value from Array", () => {
    component.setState({
      users: [0,1,2,3]
    })
    component.instance().deleteUser(0); // Removes 0
    component.instance().deleteUser(0); // REmoves 1

    expect(component.instance().state.users.length).toBe(2); // Current [2,3]
    expect(component.instance().state.users[0]).toBe(2); // Current [2,3]
  });

  it("It should Update State and return true", () => {
    component.setState({
      loading: false
    })
    component.instance().reloadData();

    expect(component.instance().state.loading).toBe(true);
  });

  it("It should display error box", () => {
    const msg = 'New Error';
    component.setState({
      error: {
        message: msg
      }
    }); // Renders Component
    expect(component.find(ErrorMsg).length).toBe(1); 

    component.setState({
      error: false
    }); // Disables Component
    expect(component.find(ErrorMsg).length).toBe(0); 
  });

  it("It should update the errorbox state", () => {
    const msg = 'New Error';
    component.setState({
      error: {
        message: msg
      }
    });
    component.instance().disableErrorBox(); // Disables Component
    expect(component.instance().state.error).toBe(false); 
  });
});
