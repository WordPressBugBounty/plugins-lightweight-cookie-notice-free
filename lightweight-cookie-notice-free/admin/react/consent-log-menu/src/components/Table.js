const useState = wp.element.useState;
import Pagination from '../../../shared-components/pagination/Pagination';

const useMemo = wp.element.useMemo;
const {__} = wp.i18n;
import {downloadFileFromString} from '../../../utils/utils';

let PageSize = 10;

const Chart = (props) => {

    //Pagination - START --------------------------------------------------------

    const [currentPage, setCurrentPage] = useState(1);

    const currentTableData = useMemo(() => {
        const firstPageIndex = (currentPage - 1) * PageSize;
        const lastPageIndex = firstPageIndex + PageSize;
        return props.data.slice(firstPageIndex, lastPageIndex);
    }, [currentPage, props.data]);

    //Pagination - END ----------------------------------------------------------

    function handleDataIcon(columnName) {

        return props.formData.sortingColumn === columnName ? props.formData.sortingOrder : '';

    }

    function setPageTitleFont(doc){
        doc.setFontSize(20);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor('#3c434a');
    }

    function setHeadingFont(doc){
        doc.setFontSize(9);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor('#3c434a');
    }

    function setParagraphFont(doc){
        doc.setFontSize(9);
        doc.setFont('helvetica', 'normal');
        doc.setTextColor('#3c434a');
    }

    /**
     * Download the file with the CSV data.
     */
    function downloadExportFile(row) {

        downloadFileFromString(row.formatted_state, 'consolidated-state' + '-' + row.consent_log_id , 'json');

    }

    /**
     * Expand the cell content.
     *
     * Specifically. Hide the parent of the current cell and display the next element related to the parent of the
     * current cell.
     */
    function expandCellContent(event) {

        const cell = event.target.closest('.table-cell-abbreviated-content');
        const cellFullContent = cell.nextElementSibling;

        if (cellFullContent.style.display === 'block') {
            cellFullContent.style.display = 'none';
            cell.style.display = 'block';
        } else {
            cellFullContent.style.display = 'block';
            cell.style.display = 'none';
        }

    }

    return (

        <div className="daextlwcnf-data-table-container">

            <table className="daextlwcnf-react-table__daextlwcnf-data-table daextlwcnf-react-table__daextlwcnf-data-table-dashboard-menu">
                <thead>
                <tr>
                    <th>
                        <button
                            className={'daextlwcnf-react-table__daextlwcnf-sorting-button'}
                            onClick={props.handleSortingChanges}
                            value={'consent_id'}
                            data-icon={handleDataIcon('consent_id')}
                        >{__('Consent ID', 'lightweight-cookie-notice-free')}</button>
                    </th>
                    <th>
                        <button
                            className={'daextlwcnf-react-table__daextlwcnf-sorting-button'}
                            onClick={props.handleSortingChanges}
                            value={'anonymized_user_ip'}
                            data-icon={handleDataIcon('anonymized_user_ip')}
                        >{__('Anonymized User IP', 'lightweight-cookie-notice-free')}</button>
                    </th>
                    <th>
                        <button
                            className={'daextlwcnf-react-table__daextlwcnf-sorting-button'}
                            onClick={props.handleSortingChanges}
                            value={'country_code'}
                            data-icon={handleDataIcon('country_code')}
                        >{__('Country', 'lightweight-cookie-notice-free')}</button>
                    </th>
                    <th>
                        <button
                            className={'daextlwcnf-react-table__daextlwcnf-sorting-button'}
                            onClick={props.handleSortingChanges}
                            value={'date'}
                            data-icon={handleDataIcon('date')}
                        >{__('Date/Time ± 0', 'lightweight-cookie-notice-free')}</button>
                    </th>
                    <th>
                        <button
                            className={'daextlwcnf-react-table__daextlwcnf-sorting-button'}
                            onClick={props.handleSortingChanges}
                            value={'user_agent'}
                            data-icon={handleDataIcon('user_agent')}
                        >{__('User Agent', 'lightweight-cookie-notice-free')}</button>
                    </th>
                    <th>
                        <button
                            className={'daextlwcnf-react-table__daextlwcnf-sorting-button'}
                            onClick={props.handleSortingChanges}
                            value={'url'}
                            data-icon={handleDataIcon('url')}
                        >{__('URL', 'lightweight-cookie-notice-free')}</button>
                    </th>
                    <th>
                        <button
                            className={'daextlwcnf-react-table__daextlwcnf-sorting-button'}
                            onClick={props.handleSortingChanges}
                            value={'encrypted_key'}
                            data-icon={handleDataIcon('encrypted_key')}
                        >{__('Encrypted Key', 'lightweight-cookie-notice-free')}</button>
                    </th>
                    <th>
                        <div className={'daextlwcnf-react-table__daextlwcnf-table-head-label'}>State</div>
                    </th>
                </tr>
                </thead>
                <tbody>

                {currentTableData.map((row) => (
                    <tr key={row.consent_log_id}>
                        <td>
                            <div className={'table-cell-abbreviated-content'}>
                                {row.consent_id.substring(0, 14) + ' ... '}
                                <button
                                    className={'table-cell-expand-button daextlwcnf-btn daextlwcnf-btn-secondary'}
                                    onClick={(event) => expandCellContent(event)}
                                >+
                                </button>
                            </div>
                            <div className={'table-cell-full-content'}>{row.consent_id}</div>
                        </td>
                        <td>{row.anonymized_user_ip !== '' ? row.anonymized_user_ip : __('N/A', 'lightweight-cookie-notice-free')}</td>
                        <td>{row.country_code !== '' ? row.country_code : __('N/A', 'lightweight-cookie-notice-free')}</td>
                        <td>{row.formatted_date}</td>
                        <td>
                            <div className={'table-cell-abbreviated-content'}>
                                {row.user_agent.substring(0, 14) + ' ... '}
                                <button
                                    className={'table-cell-expand-button daextlwcnf-btn daextlwcnf-btn-secondary'}
                                    onClick={(event) => expandCellContent(event)}
                                >+
                                </button>
                            </div>
                            <div className={'table-cell-full-content'}>{row.user_agent}</div>
                        </td>
                        <td>
                            <div className={'table-cell-abbreviated-content'}>
                                {row.url.substring(0, 14) + ' ... '}
                                <button
                                    className={'table-cell-expand-button daextlwcnf-btn daextlwcnf-btn-secondary'}
                                    onClick={(event) => expandCellContent(event)}
                                >+
                                </button>
                            </div>
                            <div className={'table-cell-full-content'}>{row.url}</div>
                        </td>
                        <td>
                            <div className={'table-cell-abbreviated-content'}>
                                {row.encrypted_key.substring(0, 14) + ' ... '}
                                <button
                                    className={'table-cell-expand-button daextlwcnf-btn daextlwcnf-btn-secondary'}
                                    onClick={(event) => expandCellContent(event)}
                                >+
                                </button>
                            </div>
                            <div className={'table-cell-full-content'}>{row.encrypted_key}</div>
                        </td>
                        <td>
                            <button
                                className={'small-button'}
                                onClick={() => downloadExportFile(row)}
                            >Download
                            </button>
                        </td>
                    </tr>
                ))}

                </tbody>
            </table>

            {props.data.length === 0 && <div
                className="daextlwcnf-no-data-found">{__('We couldn\'t find any results matching your filters. Try adjusting your criteria.', 'lightweight-cookie-notice-free')}</div>}
            {props.data.length > 0 &&
                <div className="daextlwcnf-react-table__pagination-container">
                    <div className='daext-displaying-num'>{props.data.length + ' items'}</div>
                    <Pagination
                        className="pagination-bar"
                        currentPage={currentPage}
                        totalCount={props.data.length}
                        pageSize={PageSize}
                        onPageChange={page => setCurrentPage(page)}
                    />
                </div>
            }

        </div>

    );

};

export default Chart;
