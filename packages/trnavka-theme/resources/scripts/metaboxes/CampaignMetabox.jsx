const { render } = wp.element;
const { useSelect, useDispatch } = wp.data;

const MyMetaBox = () => {
    const meta = useSelect(function (select) {
        const data = select("core/editor").getEditedPostAttribute("meta");
        return data; // ? data['_better_meta_box_value'] : false;
    }, []);

    console.log(meta);

    const { editPost } = useDispatch("core/editor");

    return (
        <div>
            <p>This is a better Meta Box.</p>
        </div>
    );
};

// render(<MyMetaBox />, document.getElementById("App_Metabox_CampaignMetabox"));
