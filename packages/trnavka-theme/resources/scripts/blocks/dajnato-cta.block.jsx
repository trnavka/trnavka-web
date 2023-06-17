import TextareaAutosize from 'react-textarea-autosize';

export default {
    name: 'theme/dajnato-cta-block',
    title: 'Daj na to CTA',
    category: 'theme',
    edit: (props) =>
            <div className={'dajnato-cta-block-editor'}>
                <TextareaAutosize
                        className={'regular-text dajnato-title'}
                        onChange={event => {
                            props.setAttributes(
                                    {
                                        ...props.attributes,
                                        title: event.target.value
                                    });
                        }}
                        value={props.attributes.title}
                />
                <div className={'dajnato-values'}>
                    <select onChange={event => {
                        props.setAttributes(
                                {
                                    ...props.attributes,
                                    campaign_id: event.target.value
                                });
                    }} value={props.attributes.campaign_id}>
                        <option>automaticky zvolená kampaň</option>
                        <option value={'button'}>len CTA tlačidlo</option>
                        {props.attributes.campaigns.map(
                                (campaign,
                                        index) =>
                                        <option key={index} value={campaign['id']}>{campaign['title']}</option>)}
                    </select>
                </div>
                {'button' === props.attributes.campaign_id && <div className={'button-url'}>
                    Url tlačidla: <input
                            type="text"
                            className={'regular-text'}
                            onChange={event => {
                                props.setAttributes(
                                        {
                                            ...props.attributes,
                                            button_url: event.target.value
                                        });
                            }}
                            value={props.attributes.button_url}
                    />
                </div>}
                <input
                        type="text"
                        className={'regular-text dajnato-button'}
                        onChange={event => {
                            props.setAttributes(
                                    {
                                        ...props.attributes,
                                        button: event.target.value
                                    });
                        }}
                        value={props.attributes.button}
                />
            </div>
};
