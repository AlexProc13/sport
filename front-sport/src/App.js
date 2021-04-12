import axios from 'axios';
import React from 'react';
import './App.css';

class App extends React.Component {
    constructor(props) {
        super(props);

        this.playAll = this.playAll.bind(this);
        this.nextWeek = this.nextWeek.bind(this);

        // setInterval(() => {
        //     this.setState({
        //         loaded: !this.state.loaded,
        //     });
        // }, 2000);

        this.state = {
            loaded: false,
        };
    }

    componentDidMount() {
        //get data by server
        console.log('get data', this.getUrls('getData'));
        axios.get(this.getUrls('getData'))
            .then(res => {
                if (res.data.status === true) {
                    console.log(res.data.data);
                    this.setState(res.data.data);

                    this.setState({
                        loaded: true,
                    });

                }
            })
    }

    getUrls(key) {
        const urls = {
            getData: process.env.REACT_APP_URL_GET_DATA,
            playAll: process.env.REACT_APP_URL_PLAY_ALL,
            nextWeek: process.env.REACT_APP_URL_NEXT_WEEK,
        };

        return urls[key];
    }

    playAll() {
        console.log('play');
        this.setState({
            loaded: false,
        });
        axios.post(this.getUrls('playAll'))
            .then(res => {
                if (res.data.status === true) {
                    this.setState({
                        loaded: true,
                    });

                    this.setState(res.data.data);
                }
            })
    }

    nextWeek() {
        console.log('nextWeek');
        this.setState({
            loaded: false,
        });
        axios.post(this.getUrls('playAll'))
            .then(res => {
                if (res.data.status === true) {
                    this.setState({
                        loaded: true,
                    });

                    this.setState(res.data.data);
                }
            })
    }

    render() {
        return (
            this.state.loaded ? <div className="container">
                    <div className="fistBlock">
                        <div className="tableBlock">
                            <h4>League Table</h4>
                            <table>
                                <thead>
                                <tr>
                                    <th>Teams</th>
                                    <th>PTS</th>
                                    <th>P</th>
                                    <th>W</th>
                                    <th>D</th>
                                    <th>L</th>
                                    <th>GD</th>
                                </tr>
                                </thead>
                                <tbody>

                                {this.state.table.map((value, index) => {
                                    return <tr key={index + this.state.season}>
                                        <td>{value.team}</td>
                                        <td>{value.pts}</td>
                                        <td>{value.p}</td>
                                        <td>{value.w}</td>
                                        <td>{value.d}</td>
                                        <td>{value.l}</td>
                                        <td>{value.gd}</td>
                                    </tr>
                                })}

                                </tbody>
                            </table>

                            <p>
                                <button onClick={this.playAll}>Play all</button>
                                <button onClick={this.nextWeek}>Next Week</button>
                            </p>
                        </div>
                        <div className="resultBlock">
                            <h4>{this.state.week}th Week Predictions of Championship</h4>

                            {this.state.matches.map((value, index) => {
                                return <p key={index + this.state.season}>{value.home} <b>{value.score}</b> {value.away}</p>
                            })}

                        </div>
                    </div>
                    <div className="secondBlock">
                        <div className="predictionBlock">
                            <h4>{this.state.week}th Week Predictions of Championship</h4>
                            <table>
                                <tbody>

                                {this.state.predictions.map((value, index) => {
                                    return <tr key={index + this.state.season}>
                                        <td>{value.team}</td>
                                        <td>{value.percent}%</td>
                                    </tr>
                                })}

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                :
                <div className="loading"><h2>LOADING...</h2></div>
        );
    }
}

export default App;
