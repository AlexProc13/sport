import React from 'react';
import './App.css';

class App extends React.Component {
    constructor(props) {
        super(props);
        this.state = {};
    }

    componentDidMount() {
        //get data by server
    }

    render() {
        return (
            <div className="container">
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
                            <tr>
                                <td>Zenit</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>Zenit</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>Zenit</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>Zenit</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>5</td>
                            </tr>
                            </tbody>
                        </table>

                        <p>
                            <button>Play all</button>
                            <button>Next Week</button>
                        </p>
                    </div>
                    <div className="resultBlock">
                        <h4>weekTH Week Predictions of Championship</h4>
                        <p>Team 1 <b>3-2</b> Team2</p>
                        <p>Team 1 <b>3-2</b> Team2</p>
                    </div>
                </div>
                <div className="secondBlock">
                    <div className="predictionBlock">
                        <h4>weekTH Week Predictions of Championship</h4>
                        <table>
                            <tbody>
                            <tr>
                                <td>Zenit</td>
                                <td>50%</td>
                            </tr>
                            <tr>
                                <td>Zenit</td>
                                <td>50%</td>
                            </tr>
                            <tr>
                                <td>Zenit</td>
                                <td>50%</td>
                            </tr>
                            <tr>
                                <td>Zenit</td>
                                <td>50%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        );
    }
}

export default App;
