import Table from './components/Table';
import RefreshIcon from '../../../assets/img/icons/refresh-cw-01.svg';
import LoadingScreen from "../../shared-components/LoadingScreen";

const useState = wp.element.useState;
const useEffect = wp.element.useEffect;

const {__} = wp.i18n;

const App = () => {

    const [formData, setFormData] = useState(
        {
            optimizationStatus: 0,
            searchString: '',
            searchStringChanged: false,
            sortingColumn: 'date',
            sortingOrder: 'desc'
        }
    );

    const [dataAreLoading, setDataAreLoading] = useState(true);

    const [dataUpdateRequired, setDataUpdateRequired] = useState(false);

    const [tableData, setTableData] = useState([]);
    const [statistics, setStatistics] = useState({
        allRecords: 0,
        acceptanceRate: 'N/A'
    });

    useEffect(() => {

        setDataAreLoading(true);

        /**
         * Initialize the chart data with the data received from the REST API
         * endpoint provided by the plugin.
         */
        wp.apiFetch({
            path: '/lightweight-cookie-notice-free/v1/consent-log',
            method: 'POST',
            data: {
                search_string: formData.searchString,
                sorting_column: formData.sortingColumn,
                sorting_order: formData.sortingOrder,
                data_update_required: dataUpdateRequired
            }
        }).then(data => {

                // Set the table data with setTableData().
                setTableData(data.table);

                // Set the statistics.
                setStatistics({
                    allRecords: data.statistics.all_records,
                    acceptanceRate: data.statistics.acceptance_rate
                });

                if (dataUpdateRequired) {

                    // Set the dataUpdateRequired state to false.
                    setDataUpdateRequired(false);

                    // Set the form data to the initial state.
                    setFormData({
                        searchString: '',
                        searchStringChanged: false,
                        sortingColumn: 'date',
                        sortingOrder: 'desc'
                    });

                }

                setDataAreLoading(false);

        }).catch(error => {

            setDataAreLoading(false);

            // Set data to the initial state.
            setTableData([]);
            setStatistics({
                allRecords: 0,
                acceptanceRate: 'N/A'
            });

            /**
             * Since this type of error is typically caused by a misconfiguration of the options and the resulting
             * server side error 500 "Allowed memory size of xxx bytes exhausted" we set the options involved in the
             * error to the default values.
             */
            wp.apiFetch({
                path: '/lightweight-cookie-notice-free/v1/options',
                method: 'POST',
                data: {
                    'daextlwcnf_max_displayed_consent_log_records': 1000,
                },
            }).then(data => {
                // Do nothing.
            });

        });

    }, [
        formData.searchStringChanged,
        formData.sortingColumn,
        formData.sortingOrder,
        dataUpdateRequired
    ]);

    /**
     * Function to handle key press events.
     *
     * @param event
     */
    function handleKeyUp(event) {

        // Check if Enter key is pressed (key code 13).
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission.
            document.getElementById('daextlwcnf-search-button').click(); // Simulate click on search button.
        }

    }

    /**
     * Handle sorting changes.
     * @param e
     */
    function handleSortingChanges(e) {

        /**
         * Check if the sorting column is the same as the previous one.
         * If it is, change the sorting order.
         * If it is not, change the sorting column and set the sorting order to 'asc'.
         */
        let sortingOrder = formData.sortingOrder;
        if (formData.sortingColumn === e.target.value) {
            sortingOrder = formData.sortingOrder === 'asc' ? 'desc' : 'asc';
        }

        setFormData({
            ...formData,
            sortingColumn: e.target.value,
            sortingOrder: sortingOrder
        })

    }

    /**
     * Used to toggle the dataUpdateRequired value.
     * @param e
     */
    function handleDataUpdateRequired(e) {
        setDataUpdateRequired(prevDataUpdateRequired => {
            return !prevDataUpdateRequired;
        });
    }

    return (

        <>

            <React.StrictMode>

                {
                    !dataAreLoading ?

                        <div className="daextlwcnf-admin-body">

                            <div className={'daextlwcnf-react-table'}>

                                <div className={'daextlwcnf-react-table-header'}>
                                    <div className={'statistics'}>
                                        <div className={'statistic-label'}>{__('All records', 'lightweight-cookie-notice-free')}:</div>
                                        <div className={'statistic-value'}>{statistics.allRecords}</div>
                                        <div className={'statistic-label'}>{__('Acceptance Rate', 'lightweight-cookie-notice-free')}:</div>
                                        <div className={'statistic-value'}>{statistics.acceptanceRate}</div>
                                    </div>
                                    <div className={'tools-actions'}>
                                        <button
                                            onClick={(event) => handleDataUpdateRequired(event)}
                                        ><img src={RefreshIcon} className={'button-icon'}></img>
                                            {__('Update metrics', 'lightweight-cookie-notice-free')}
                                        </button>
                                    </div>
                                </div>

                                <div className={'daextlwcnf-react-table__daextlwcnf-filters daextlwcnf-react-table__daextlwcnf-filters-dashboard-menu'}>

                                    <div className={'daextlwcnf-search-container'}>
                                        <input
                                            onKeyUp={handleKeyUp}
                                            type={'text'} placeholder={__('Filter by URL', 'lightweight-cookie-notice-free')}
                                            value={formData.searchString}
                                            onChange={(event) => setFormData({
                                                ...formData,
                                                searchString: event.target.value
                                            })}
                                        />
                                        <input id={'daextlwcnf-search-button'} className={'daextlwcnf-btn daextlwcnf-btn-secondary'}
                                               type={'submit'} value={__('Search', 'lightweight-cookie-notice-free')}
                                               onClick={() => setFormData({
                                                   ...formData,
                                                   searchStringChanged: formData.searchStringChanged ? false : true
                                               })}
                                        />
                                    </div>

                                </div>

                                <Table
                                    data={tableData}
                                    handleSortingChanges={handleSortingChanges}
                                    formData={formData}
                                />

                            </div>

                        </div>

                        :
                        <LoadingScreen
                            loadingDataMessage={__('Loading data...', 'lightweight-cookie-notice-free')}
                            generatingDataMessage={__('Data is being generated. For large sites, this process may take several minutes. Please wait...', 'lightweight-cookie-notice-free')}
                            dataUpdateRequired={dataUpdateRequired}/>
                }

            </React.StrictMode>

        </>

    );

};
export default App;