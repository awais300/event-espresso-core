import React, { useCallback } from 'react';
import { __ } from '@wordpress/i18n';

import { EspressoButton, Icon } from '@application/ui/input';
import { EntityListItemProps } from '@appLayout/entityList';
import ItemCount from '@appDisplay/ItemCount';
import { useRelatedTickets } from '@edtrServices/apollo/queries';
import useTicketAssignmentsManager from '@edtrUI/ticketAssignmentsManager/useTicketAssignmentsManager';
import { TypeName } from '@appServices/apollo/status';
import withIsLoaded from '@sharedUI/hoc/withIsLoaded';

const AssignTicketsButton: React.FC<EntityListItemProps> = React.memo(({ id, name }) => {
	const { assignTicketsToDate } = useTicketAssignmentsManager();

	const relatedTickets = useRelatedTickets({
		entity: 'datetimes',
		entityId: id,
	});
	const count = relatedTickets.length;

	const relatedTicketDbIds = relatedTickets.map(({ dbId }) => dbId);

	const title = count
		? `${__('Related Tickets:')} ${relatedTicketDbIds.join(', ')}`
		: __('There are no tickets assigned to this datetime. Please click the ticket icon to update the assignments.');

	const onClick = useCallback((): void => {
		assignTicketsToDate({ datetimeId: id, name });
	}, [id, name]);

	return (
		<ItemCount count={count} title={title} zeroCountChar='!' emphasizeZero>
			<EspressoButton
				icon={Icon.TICKET}
				tooltip={__('assign tickets')}
				tooltipProps={{ placement: 'right' }}
				onClick={onClick}
			/>
		</ItemCount>
	);
});

export default withIsLoaded<EntityListItemProps>(TypeName.tickets, ({ loaded, id, name }) => {
	/* Hide TAM unless tickets are loaded */
	return loaded && <AssignTicketsButton id={id} name={name}/>;
});
