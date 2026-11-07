import Pagination from '../../../shared-components/pagination/Pagination';

const {__} = wp.i18n;
import {downloadFileFromString} from '../../../utils/utils';

/**
 * Note that the records are paginated on the server, so props.data includes only the records of the current page.
 */
const Chart = (props) => {

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
     * Download the file with the state of the consent log record.
     *
     * The state is retrieved from the server only when it's downloaded, since it's not included in the table data.
     */
    function downloadExportFile(row) {

        wp.apiFetch({
            path: '/lightweight-cookie-notice-free/v1/consent-log-state',
            method: 'POST',
            data: {
                consent_log_id: row.consent_log_id
            }
        }).then(data => {

            downloadFileFromString(data.formatted_state, 'consolidated-state' + '-' + row.consent_log_id , 'json');

        });

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
                        <div className={'daextlwcnf-react-table__daextlwcnf-table-head-label'}>{__('Consent ID', 'lightweight-cookie-notice-free')}</div>
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
                        <div className={'daextlwcnf-react-table__daextlwcnf-table-head-label'}>{__('Encrypted Key', 'lightweight-cookie-notice-free')}</div>
                    </th>
                    <th>
                        <div className={'daextlwcnf-react-table__daextlwcnf-table-head-label'}>State</div>
                    </th>
                </tr>
                </thead>
                <tbody>

                {props.data.map((row) => (
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
                    <div className='daext-displaying-num'>{props.totalItems + ' items'}</div>
                    <Pagination
                        className="pagination-bar"
                        currentPage={props.currentPage}
                        totalCount={props.totalItems}
                        pageSize={props.itemsPerPage}
                        onPageChange={props.onPageChange}
                    />
                </div>
            }

        </div>

    );

};

export default Chart;
