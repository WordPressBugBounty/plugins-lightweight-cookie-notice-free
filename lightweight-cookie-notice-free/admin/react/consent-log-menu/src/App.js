import Table from './components/Table';
import RefreshIcon from '../../../assets/img/icons/refresh-cw-01.svg';
import LoadingScreen from "../../shared-components/LoadingScreen";

const useState = wp.element.useState;
const useEffect = wp.element.useEffect;
const useRef = wp.element.useRef;

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

    // The full loading screen is displayed only on the first load and when the metrics are updated.
    const [dataAreLoading, setDataAreLoading] = useState(true);

    // Used to dim the table while a page, a sorting, or a search is loaded.
    const [dataAreRefreshing, setDataAreRefreshing] = useState(false);

    const [dataUpdateRequired, setDataUpdateRequired] = useState(false);

    const [tableData, setTableData] = useState([]);
    const [statistics, setStatistics] = useState({
        allRecords: 0,
        acceptanceRate: 'N/A'
    });

    // The records are paginated on the server, so only the records of the current page are retrieved.
    const [currentPage, setCurrentPage] = useState(1);
    const [pagination, setPagination] = useState({
        itemsPerPage: 10,
        totalItems: 0
    });

    // Used to ignore the responses of requests that have been replaced by more recent requests.
    const lastRequestId = useRef(0);

    useEffect(() => {

        const requestId = ++lastRequestId.current;

        if (dataUpdateRequired) {
            setDataAreLoading(true);
        } else {
            setDataAreRefreshing(true);
        }

        /**
         * Initialize the table data with the data received from the REST API
         * endpoint provided by the plugin.
         */
        wp.apiFetch({
            path: '/lightweight-cookie-notice-free/v1/consent-log',
            method: 'POST',
            data: {
                search_string: formData.searchString,
                sorting_column: formData.sortingColumn,
                sorting_order: formData.sortingOrder,
                current_page: currentPage,
                data_update_required: dataUpdateRequired
            }
        }).then(data => {

                // Ignore the response if a more recent request has been sent.
                if (requestId !== lastRequestId.current) {
                    return;
                }

                // Set the table data with setTableData().
                setTableData(data.table);

                // Set the statistics.
                setStatistics({
                    allRecords: data.statistics.all_records,
                    acceptanceRate: data.statistics.acceptance_rate
                });

                // Set the pagination data. The current page is adjusted by the server when it's out of range.
                setPagination({
                    itemsPerPage: data.pagination.items_per_page,
                    totalItems: data.pagination.total_items
                });
                if (data.pagination.current_page !== currentPage) {
                    setCurrentPage(data.pagination.current_page);
                }

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
                setDataAreRefreshing(false);

        }).catch(error => {

            // Ignore the response if a more recent request has been sent.
            if (requestId !== lastRequestId.current) {
                return;
            }

            setDataAreLoading(false);
            setDataAreRefreshing(false);

            // Set data to the initial state.
            setTableData([]);
            setStatistics({
                allRecords: 0,
                acceptanceRate: 'N/A'
            });
            setPagination({
                itemsPerPage: 10,
                totalItems: 0
            });

        });

    }, [
        formData.searchStringChanged,
        formData.sortingColumn,
        formData.sortingOrder,
        currentPage,
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

        // Display the first page of the newly sorted records.
        setCurrentPage(1);

    }

    /**
     * Used to toggle the dataUpdateRequired value.
     * @param e
     */
    function handleDataUpdateRequired(e) {
        setCurrentPage(1);
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

                            <div className={'daextlwcnf-react-table' + (dataAreRefreshing ? ' daextlwcnf-react-table--refreshing' : '')}>

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
                                               onClick={() => {
                                                   setFormData({
                                                       ...formData,
                                                       searchStringChanged: formData.searchStringChanged ? false : true
                                                   });

                                                   // Display the first page of the search results.
                                                   setCurrentPage(1);
                                               }}
                                        />
                                    </div>

                                </div>

                                <Table
                                    data={tableData}
                                    handleSortingChanges={handleSortingChanges}
                                    formData={formData}
                                    currentPage={currentPage}
                                    itemsPerPage={pagination.itemsPerPage}
                                    totalItems={pagination.totalItems}
                                    onPageChange={page => setCurrentPage(page)}
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