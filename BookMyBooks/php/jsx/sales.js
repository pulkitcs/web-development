const ALL = 'all';
const TODAY = new Date().toISOString().split('T')[0];

function RenderAll({ totalOrders = 0, totalEarnings = 0, publisherData = {}, bookDetails = {}} = {}) {
  return <div style={{'marginTop': '2rem'}}>
    <h3 style={{'margin': '2rem 0 1rem 0', 'fontSize': '1.2rem'}}>Publisher Details</h3>
    <table className="table">
      <thead>
        <tr>
          <th>SNo.</th>
          <th>Name of Publisher</th>
          <th>No. of books sold</th>
          <th>Total Earnings</th>
          <th>% Sales Contribution</th>
          <th>% Earnings Contribution</th>
        </tr>
      </thead>
      <tbody>
        {Object.keys(publisherData).map((name, index) => (
          <tr key={name}>
            <td>{index + 1}</td>
            <td>{name}</td>
            <td>{publisherData[name]['totalCopies']}</td>
            <td>₹{publisherData[name]['totalEarnings']}</td>
            <td>{(publisherData[name]['totalCopies']*100 / totalOrders).toFixed(2)}</td>
            <td>{(publisherData[name]['totalEarnings']*100 / totalEarnings).toFixed(2)}</td>
          </tr>
        ))}
      </tbody>
    </table>
    <h3 style={{'margin': '2rem 0 1rem 0', 'fontSize': '1.2rem'}}>Book Details</h3>
    <table className="table">
      <thead>
        <tr>
          <th>SNo.</th>
          <th>ISBN</th>
          <th>Title</th>
          <th>Author</th>
          <th>Publisher</th>
          <th>No. of Copies</th>
          <th>Total Earnings</th>
        </tr>
      </thead>
      <tbody>
        {Object.keys(bookDetails).map((ISBN, index) => <tr key={ISBN}>
          <td>{index + 1}</td>
          <td>{ISBN}</td>
          <td>{bookDetails[ISBN]['title']}</td>
          <td>{bookDetails[ISBN]['author']}</td>
          <td>{bookDetails[ISBN]['publisher']}</td>
          <td>{bookDetails[ISBN]['totalCopies']}</td>
          <td>₹{bookDetails[ISBN]['totalEarnings']}</td>
          </tr>
        )}
      </tbody>
    </table>
  </div>
}

function RenderByPublisher(publisherName, {totalCopies, totalEarnings} = {}, booksData = {}) {
  return <div style={{'marginTop': '2rem'}}>
    <h3 style={{'margin': '2rem 0 1rem 0', 'fontSize': '1.2rem'}}>About {publisherName}</h3>
    <table className="table">
      <thead>
        <tr>
          <th>No. of Books Sold</th>
          <th>Total Earnings</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{totalCopies}</td>
          <td>₹{totalEarnings}</td>
        </tr>
      </tbody>
    </table>
    <h3 style={{'margin': '2rem 0 1rem 0', 'fontSize': '1.2rem'}}>Books Ordered</h3>
    <table className="table">
      <thead>
        <tr>
          <th>SNo.</th>
          <th>ISBN</th>
          <th>Title</th>
          <th>Author</th>
          <th>No. of Copies</th>
          <th>Total Earnings</th>
        </tr>
      </thead>
      <tbody>
        {Object.keys(booksData).map((ISBN, index) => <tr key={ISBN}>
          <td>{index + 1}</td>
          <td>{ISBN}</td>
          <td>{booksData[ISBN]['title']}</td>
          <td>{booksData[ISBN]['author']}</td>
          <td>{booksData[ISBN]['totalCopies']}</td>
          <td>₹{booksData[ISBN]['totalEarnings']}</td>
          </tr>
        )}
      </tbody>
    </table>
  </div>
}

function SalesApp() {
  const { useEffect, useMemo, useState } = React;
  const  [data, setData] = useState(null);
  const [filter, setFilter] = useState(ALL);
  const [startDate, setStartDate] = useState('');
  const [endDate, setEndDate] = useState(TODAY);
  const [dateFilter, setDateFilter] = useState('');
  
  useEffect(() => {
    async function fetchData() {
      const response = await window.fetch(`./api/order.php?status=2${dateFilter}`, {
        headers: {
          'Content-Type': 'Application/json',
        }
      });

      try {
        const orderList = await response.json();
        setData(orderList);
      }
      catch(e) {
        throw new Error(e.message);
      }
    }

    fetchData();
  }, [dateFilter])

  const structuredData = useMemo(() => data?.reduce((acc, current) => {
    const { details } = current;
    const data = JSON.parse(details);
    let { bookDetails, publisherData, totalEarnings, totalOrders } = {...acc};

    for (let i in data) {
      const { author, publisher, price, quantity, title, } = data[i];

      if(!publisherData[publisher]) {
        publisherData[publisher] = {}
        publisherData[publisher]['totalEarnings'] = 0;
        publisherData[publisher]['totalCopies'] = 0;
        publisherData[publisher]['books'] = {};
      }

      if(!publisherData[publisher]['books'][i]) {
        publisherData[publisher]['books'][i] = {};
        publisherData[publisher]['books'][i]['totalEarnings'] = 0;
        publisherData[publisher]['books'][i]['totalCopies'] = 0;
      } 

      if(!bookDetails[i]){
        bookDetails[i] = {};
        bookDetails[i]['totalEarnings'] = 0;
        bookDetails[i]['totalCopies'] = 0;
      }

      bookDetails[i]['author'] = author;
      bookDetails[i]['publisher'] = publisher;
      bookDetails[i]['title'] = title;
      bookDetails[i]['totalEarnings'] += price*quantity;
      bookDetails[i]['totalCopies'] += quantity;

      publisherData[publisher]['books'][i]['author'] = author;
      publisherData[publisher]['books'][i]['title'] = title;
      publisherData[publisher]['books'][i]['totalEarnings'] += price*quantity;
      publisherData[publisher]['books'][i]['totalCopies'] += quantity;
      
      publisherData[publisher]['totalEarnings'] += price*quantity;
      publisherData[publisher]['totalCopies'] += quantity;

      totalEarnings += price*quantity;
      totalOrders += quantity;
    }

    return ({
      bookDetails,
      totalOrders,
      totalEarnings,
      publisherData
    });
  }, {  totalOrders: 0, totalEarnings: 0, publisherData: {}, bookDetails: {} }), [data]);

  function handleChange(e) {
    setFilter(e.target.value);
  }

  function handleReset() {
    setStartDate('');
    setEndDate(TODAY);
    setDateFilter('');
  }

  function handleApplyFilter() {
    const dateQuery = `&startdate=${startDate}&enddate=${endDate}`;
    setDateFilter(dateQuery);
  }

  function renderData(filter) {
    if(filter === ALL)
      return RenderAll(structuredData);
    else return RenderByPublisher(filter, structuredData?.publisherData[filter], structuredData?.publisherData?.[filter]?.['books']);
  }

  return (<div className="sub-section">
    <div className="side-control">
      <h1 className="heading">Filter By</h1>
      <aside className="filter-controls">
        <h3>Date</h3>
        <div>Start Date <input className="filter-date" type="date" max={TODAY} value={startDate} onChange={({ target: { value }}) => setStartDate(value)}/></div>
        <div>End Date <input className="filter-date" type="date" max={TODAY} value={endDate} onChange={({ target: { value }}) => setEndDate(value)}/></div>
        <button className="filter-button" type="button" onClick={handleReset}>Reset</button> 
        <button className="filter-button" type="button" onClick={handleApplyFilter} disabled={!(startDate && endDate)}>Apply Filter</button>
        <h3>Publishers</h3>
        <select className="choose-publisher" onChange={handleChange}>
          <option value={ALL}>All</option>
          {!!structuredData?.publisherData && Object.keys(structuredData?.publisherData).map((key) => <option key={key} value={key}>{key}</option>)}
        </select>
      </aside>
    </div>
    <div className="content">
      <h1 className="heading">Sales</h1>
      <p className="date_details">{startDate && endDate ? `(${startDate} to ${endDate})` : ''}</p>
      <div>
        <p className="total-sales">Store Total Earnings: <strong> ₹{structuredData?.totalEarnings}</strong></p>
        <p className="total-sales">Store Total Books Sold: <strong>{structuredData?.totalOrders}</strong></p>
      </div>
      {renderData(filter)}
    </div>
  </div>);
}