import React, { useEffect, useState } from "react";
import ReactDOM from 'react-dom';
import CampaignImages from './CampaignImages'

function Campaigns() {
    const [campaigns, setCampaigns] = useState([])
    const [showLoading, setShowLoading] = useState("")
    const [campaignImages, setCampaignImages] = useState([])
    useEffect(()=>{
        fetchCampaigns();
        setCampaignImages(campaignImages ?? []);
    },[])

    const fetchCampaigns = async () => {
        setShowLoading(true)
        await axios.get(`http://eskimi.local/api/campaigns`).then(({data})=>{
            console.log(data)
                if (data.success) {
                    setCampaigns(data.message)
                }else{
                    alert('something went wrong')
                }
                setShowLoading(false)
            }).catch(({response:{data}})=>{
                setShowLoading(false)
                alert('something went wrong')
            })
    }

    function showImages(images){
        console.log('image')
        console.log(images)
        setCampaignImages(images)
    }

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div id="campaign-images"></div>
                        {campaignImages.length > 0 &&
                            <CampaignImages campaignImages={campaignImages} />
                        }
                        <div className="card-header">Campaigns Component</div>
                        {showLoading &&
                            <div style={{position: 'absolute',width: '100%',height: '100%',background: '#f4f4f4',textAlign: 'center'}}>
                                <h2>Loading....</h2>
                            </div>
                        }
                        
                        <div className="card-body">
                            <table className="table table-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Total Budget</th>
                                        <th scope="col">Daily Budget</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {
                                        campaigns.length > 0 && (
                                            campaigns.map((row, key)=>(
                                                <tr key={key}>
                                                    <th scope="row">{row.id}</th>
                                                    <td>{row.name}</td>
                                                    <td>{row.start_date} - {row.end_date}</td>
                                                    <td>{row.status}</td>
                                                    <td>{row.total_budget}</td>
                                                    <td>{row.daily_budget}</td>
                                                    <td>
                                                        <button onClick={() => showImages(row.images)} type="button" className="btn btn-info" data-toggle="modal" data-target="#myModal">
                                                        <span className="glyphicon glyphicon-picture" aria-hidden="true"></span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            ))
                                        )
                                    }
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Campaigns;

if (document.getElementById('campaigns')) {
    ReactDOM.render(<Campaigns />, document.getElementById('campaigns'));
}
