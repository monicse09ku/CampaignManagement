import React, { useEffect, useState } from "react";
import ReactDOM from 'react-dom';

function CampaignImages({campaignImages}) {
    
    return (
      <div className="modal fade" id="myModal" role="dialog">
        <div className="modal-dialog">
        
          <div className="modal-content">
            <div className="modal-header">
              <button type="button" className="close" data-dismiss="modal">&times;</button>
              <h4 className="modal-title">Campaign Images</h4>
            </div>
            <div className="modal-body">

              <div id="carousel-example-generic" className="carousel slide" data-ride="carousel">

                <div className="carousel-inner" role="listbox">
                  {
                    campaignImages.length > 0 && (
                        campaignImages.map((row, key)=>{
                          let image_source = 'images/' + row.image
                          if(key === 0){
                            return(
                              <div key={key} className="item active"><img src={image_source}/></div>
                            )
                          }else{
                            return(
                              <div key={key} className="item"><img src={image_source}/></div>
                            )
                          }
                        })
                    )
                  }
                  
                </div>

                <a className="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                  <span className="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                  <span className="sr-only">Previous</span>
                </a>
                <a className="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                  <span className="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                  <span className="sr-only">Next</span>
                </a>
              </div>

            </div>
            <div className="modal-footer">
              <button type="button" className="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
      </div>
    );
}

export default CampaignImages;


