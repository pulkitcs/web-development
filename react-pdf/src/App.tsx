import { useRef } from 'react';
import { PDFExport, savePDF } from '@progress/kendo-react-pdf'; 

export default function App() {
  const pdfExportComponent = useRef();
  const contentArea = useRef();

  const onExportWithComponent = (event) => { 
    pdfExportComponent?.current?.save(); 
  }; 

  const onExportWithMethod = (event) => { 
    savePDF(contentArea?.current, { paperSize: "A4" }); 
  }; 

  return <div ref={contentArea}>
       <PDFExport ref={pdfExportComponent}  paperSize="A4"> 
       <div> 
         <h1>KendoReact PDF Content Starts here...</h1> 
         <p>You can export using any of the two given methods</p> 
         <div> 
          <button onClick={onExportWithComponent}> 
              Export with Component 
          </button> 
          <button onClick={onExportWithMethod}>Export with Method</button> 
       </div> 
     </div> 
   </PDFExport> 
  </div>
}